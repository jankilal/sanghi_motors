<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use Redirect;
// use Yajra\DataTables\DataTables as dt;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Session;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $data = [''];
        return view('Admin.Employee.index',compact('data'));
    }

    public function create(){

        $state_list = DB::table('state')->where('country_id' , 99)->get();
        return view('Admin.Employee.add',compact('state_list'));
    }

    public function UnauthorizedAccess(){
        $data = [];
        return view('Admin.ErrorPage.unauthorized_access',compact('data'));
    }

    public function loadEmployeeData(){

        return Datatables::of(Employee::select('users.*', 'state.state_name')->join('state', 'users.state_id', '=', 'state.id'))
            ->addColumn('action', function ($loct) {
                $btnStr = '';
                $btnStr .= '<a  href="'. route('employee.edit',array($loct->id)) . '" data-id="'. $loct->id . '" class="btn btn-xs btn-btn btn-dark pull btn-edit"><i class="fa fa-pencil-square-o"></i> Edit</a>';
               // $btnStr .= '<a onclick="return myFunction();" href="'. route('employee.destroy',array($loct->id)) . '" data-id="'. $loct->id . '" class="btn btn-xs btn-danger btn-delete"><i class="fa fa-trash"></i> Delete</a>';
                return $btnStr;
            })
            ->make(true);
    }

    public function store(Request $request)
    {
       // Get the currently authenticated user...
       $user = Auth::user();        
       try{
            $id = $request->get("id", '');
            $validator = Employee::validator($request->all(), $id);
            if($validator->fails()) {
                // throw errors
                return redirect()->back()
                    ->withErrors($validator->getMessageBag())
                    ->withInput($request->all());
            }
            if($id == '') 
            {
                $employee = new Employee();
            } 
            else 
            {
                $employee = Employee::findOrFail($id);
            }
            $employee->first_name = $request->get("first_name",'');
            $employee->last_name = $request->get("last_name",'');
            $employee->user_city = $request->get("user_city",'');
            $employee->state_id = $request->get("state_id",'');
            $employee->postal_code = $request->get("postal_code",'');
            $employee->address = $request->get("address",'');
            $employee->email = $request->get("email",'');
            $employee->user_code = $request->get("user_code",'');
            $employee->phone_number = $request->get("phone_number",'');
            $employee->user_type = 'Employee';
            $employee->country_id = '99';
            $employee->role_id = '2';
            $employee->is_active = $request->get("is_active",'');
            if($request->get("password",'') != '') 
            {
                $employee->password = bcrypt($request->get("password"));
            }
            $employee->save();
            $message = 'Employee successfully'.($id == '' ? ' added' : ' updated');
            \Session::flash('flash_message',$message);
            return redirect(action('Admin\EmployeeController@index'));
        }catch(\Exception $ex){

           //LogActivity::addToLog(trans('admin.employee_'.($id == '' ? 'create' : 'edit').'_error_log').$ex->getMessage());
           return redirect(action('Admin\EmployeeController@index'))->with('error', $ex->getMessage());
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $state_list = DB::table('state')->where('country_id' , 99)->get();
        return view('Admin.Employee.edit', compact(
            'employee', 'state_list'
        ));
    }

    public function destroy($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->delete();
            return response()->json(['success' => true, 'status_code' => '1']);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage(), 'success' => false, 'status_code' => '0']);
        }
    }
}
