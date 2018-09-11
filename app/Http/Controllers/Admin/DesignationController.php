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
use App\Models\Designation;
use Illuminate\Support\Facades\DB;
use Session;

class DesignationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $data = [''];
        return view('Admin.Designation.index',compact('data'));
    }

    public function create(){

        $state_list = DB::table('state')->where('country_id' , 99)->get();
        return view('Admin.Designation.add',compact('state_list'));
    }

    public function UnauthorizedAccess(){
        $data = [];
        return view('Admin.ErrorPage.unauthorized_access',compact('data'));
    }

    public function loadDesignationData(){

        return Datatables::of(Designation::select('designation.*'))
            ->addColumn('action', function ($loct) {
                $btnStr = '';
                $btnStr .= '<a  href="'. route('designation.edit',array($loct->id)) . '" data-id="'. $loct->id . '" class="btn btn-xs btn-primary btn-edit"><i class="fa fa-pencil-square-o"></i> Edit</a>';
               // $btnStr .= '<a onclick="return myFunction();" href="'. route('designation.destroy',array($loct->id)) . '" data-id="'. $loct->id . '" class="btn btn-xs btn-danger btn-delete"><i class="fa fa-trash"></i> Delete</a>';
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
            $validator = Designation::validator($request->all(), $id);
            if($validator->fails()) {
                // throw errors
                return redirect()->back()
                    ->withErrors($validator->getMessageBag())
                    ->withInput($request->all());
            }
            if($id == '') 
            {
                $designation = new Designation();
            } 
            else 
            {
                $designation = Designation::findOrFail($id);
            }
            $designation->designation_name = $request->get("designation_name",'');
            $designation->designation_code = $request->get("designation_code",'');
            $designation->is_active = $request->get("is_active",'');
            $designation->save();
            $message = 'Designation successfully'.($id == '' ? ' added' : ' updated');
            \Session::flash('flash_message',$message);
            return redirect(action('Admin\DesignationController@index'));
        }catch(\Exception $ex){

           //LogActivity::addToLog(trans('admin.designation_'.($id == '' ? 'create' : 'edit').'_error_log').$ex->getMessage());
           return redirect(action('Admin\DesignationController@index'))->with('error', $ex->getMessage());
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $designation = Designation::findOrFail($id);
        $state_list = DB::table('state')->where('country_id' , 99)->get();
        return view('Admin.Designation.edit', compact(
            'designation', 'state_list'
        ));
    }

    public function destroy($id)
    {
        try {
            $designation = Designation::findOrFail($id);
            $designation->delete();
            return response()->json(['success' => true, 'status_code' => '1']);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage(), 'success' => false, 'status_code' => '0']);
        }
    }
}
