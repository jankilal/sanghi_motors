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
use App\Models\Dealership;
use App\Models\LOBusiness;
use Illuminate\Support\Facades\DB;
use Session;

class DealershipController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $data = [''];
        return view('Admin.Dealership.index',compact('data'));
    }

    public function create(){

        $state_list = ['' => 'Select State'] + DB::table('state')->where('country_id' , 99)->pluck('state_name' , 'id')->toArray();

        $lob_list = LOBusiness::orderBy('name','ASC')->where('is_active' , 'Active')->get();
        // $lob_list = ['' => 'Select LOB'] + LOBusiness::orderBy('name','ASC')->where('is_active' , 'Active')->pluck('name' , 'id')->toArray();
        return view('Admin.Dealership.add',compact('state_list', 'lob_list'));
    }

    public function UnauthorizedAccess(){
        $data = [];
        return view('Admin.ErrorPage.unauthorized_access',compact('data'));
    }

    public function loadDealershipData(){

        return Datatables::of(Dealership::select('dealership.*', 'state.state_name')->join('state', 'dealership.state_id', '=', 'state.id'))
            ->addColumn('action', function ($loct) {
                $btnStr = '';
                $btnStr .= '<a  href="'. route('dealership.edit',array($loct->id)) . '" data-id="'. $loct->id . '" class="btn btn-xs btn-primary btn-edit"><i class="fa fa-pencil-square-o"></i> Edit</a>';
               // $btnStr .= '<a onclick="return myFunction();" href="'. route('dealership.destroy',array($loct->id)) . '" data-id="'. $loct->id . '" class="btn btn-xs btn-danger btn-delete"><i class="fa fa-trash"></i> Delete</a>';
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
            $validator = Dealership::validator($request->all(), $id);
            if($validator->fails()) {
                // throw errors
                return redirect()->back()
                    ->withErrors($validator->getMessageBag())
                    ->withInput($request->all());
            }
            if($id == '') 
            {
                $dealership = new Dealership();
            } 
            else 
            {
                $dealership = Dealership::findOrFail($id);
            }

            $dealership->first_name = $request->get("first_name",'');
            $dealership->last_name = $request->get("last_name",'');
            $dealership->user_city = $request->get("user_city",'');
            $dealership->state_id = $request->get("state_id",'');
            $dealership->postal_code = $request->get("postal_code",'');
            $dealership->address = $request->get("address",'');
            $dealership->email = $request->get("email",'');
            $dealership->phone_number = $request->get("phone_number",'');
            $dealership->country_id = '99';
            $dealership->role_id = '3';
            $dealership->is_active = $request->get("is_active",'');
            $dealership->lob_id = implode(',', $request->get("lob_id",''));
            if($request->get("password",'') != '') 
            {
                $dealership->password = bcrypt($request->get("password"));
            }
            $dealership->save();
            $message = 'Dealership successfully'.($id == '' ? ' added' : ' updated');
            \Session::flash('flash_message',$message);
            return redirect(action('Admin\DealershipController@index'));
        }catch(\Exception $ex){

           //LogActivity::addToLog(trans('admin.dealership_'.($id == '' ? 'create' : 'edit').'_error_log').$ex->getMessage());
           return redirect(action('Admin\DealershipController@index'))->with('error', $ex->getMessage());
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $dealership = Dealership::findOrFail($id);
        $lob_list = LOBusiness::orderBy('name','ASC')->where('is_active' , 'Active')->get();
        $state_list = DB::table('state')->where('country_id' , 99)->get();
        return view('Admin.Dealership.edit', compact(
            'dealership', 'state_list', 'lob_list'
        ));
    }

    public function destroy($id)
    {
        try {
            $dealership = Dealership::findOrFail($id);
            $dealership->delete();
            return response()->json(['success' => true, 'status_code' => '1']);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage(), 'success' => false, 'status_code' => '0']);
        }
    }
}
