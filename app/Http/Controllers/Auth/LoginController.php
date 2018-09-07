<?php

namespace App\Http\Controllers\Auth;


use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Models\ActionRole;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Session;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */

    public function login(Request $request)
    {
        // $this->validateLogin($request);
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
        // Customization: Validate if client status is active (1)
        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }
        // Customization: Validate if client status is active (1)
        $email = $request->get($this->username());

        // Customization: It's assumed that email field should be an unique field
        $client = User::where($this->username(), $email)->first();

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        // Customization: If client status is inactive (0) return failed_status error.
        if (!empty($client) && $client->is_active === 'Inactive') {

            return $this->sendFailedLoginResponse($request, trans('auth.failed_status'));
        }
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {

        if(env('captcha_enable') == 1){


            $this->validate($request, [
                $this->username() => 'required|string',
                'password' => 'required|string',
                'g-recaptcha-response' => 'required|captcha',
            ],['g-recaptcha-response.required' => 'Your Captcha response was incorrect. Please try again.','g-recaptcha-response.captcha' => 'Your Captcha response was incorrect. Please try again.']);
        }
        else{
            $this->validate($request, [
                $this->username() => 'required|string',
                'password' => 'required|string'
            ]);
        }

    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $field
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request, $trans = 'auth.failed')
    {
        $errors = [$this->username() => trans($trans)];
        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

    public function credentials(Request $request)
    {
       // return $request->only($this->username(), 'password', ['is_active' => 'Active']);
        return array_merge($request->only($this->username(), 'password'), ['is_active' => 'Active']);
    }

    public function logout(Request $request)
    {
        //add log
        LogActivity::addToLog(trans('api_message.logout_activity_log'));
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect('/login');
    }

    protected function authenticated(Request $request, $user)
    {
        // $this->setUserSession($user);
        LogActivity::addToLog(trans('api_message.login_activity_log'));
        return redirect()->route('home');
    }

    protected function setUserSession($user)
    {
        // $roles = $user->role()->with('permissions')->get()->toArray();
        // $user_permissions = array_column($roles[0]['permissions'],'name');

        //select('section_data.id','action_data.id')
        $user_section_permission = ActionRole::where('role_id',$user->role_id)->select('section_id')->distinct()->get();
        $sections = $user_section_permission->toArray();
        $user_section_permission = [];
        $user_sections =[];
        if(count($sections)>0){
            foreach ($sections as $section){
                array_push($user_sections,$section['section_id']);
                $actions = ActionRole::where('role_id',$user->role_id)->where('section_id',$section['section_id'])->pluck('action_id');
                $user_section_permission[$section['section_id']] = $actions->toArray();
            }
        }
        session(
            [
                // 'Permissions' => $user_permissions,
                'user_section' => $user_sections,
                'SectionPermissions' => $user_section_permission
            ]
        );
    }
}
