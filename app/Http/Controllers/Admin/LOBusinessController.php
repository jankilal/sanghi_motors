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
use App\Models\LOBusiness;
use Illuminate\Support\Facades\DB;
use Session;

class LOBusinessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $data = [''];
        return view('Admin.LOBusiness.index',compact('data'));
    }

    public function create(){

        $state_list = DB::table('state')->where('country_id' , 99)->get();
        return view('Admin.LOBusiness.add',compact('state_list'));
    }

    public function UnauthorizedAccess(){
        $data = [];
        return view('Admin.ErrorPage.unauthorized_access',compact('data'));
    }

    public function loadLOBusinessData(){

        return Datatables::of(LOBusiness::select('line_of_business.*'))
            ->addColumn('action', function ($loct) {
                $btnStr = '';
                $btnStr .= '<a  href="'. route('lobusiness.edit',array($loct->id)) . '" data-id="'. $loct->id . '" class="btn btn-xs btn-primary btn-edit"><i class="fa fa-pencil-square-o"></i> Edit</a>';
               // $btnStr .= '<a onclick="return myFunction();" href="'. route('lobusiness.destroy',array($loct->id)) . '" data-id="'. $loct->id . '" class="btn btn-xs btn-danger btn-delete"><i class="fa fa-trash"></i> Delete</a>';
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
            $validator = LOBusiness::validator($request->all(), $id);
            if($validator->fails()) {
                // throw errors
                return redirect()->back()
                    ->withErrors($validator->getMessageBag())
                    ->withInput($request->all());
            }
            if($id == '') 
            {
                $lobusiness = new LOBusiness();
            } 
            else 
            {
                $lobusiness = LOBusiness::findOrFail($id);
            }
            $lobusiness->name = $request->get("name",'');
            $lobusiness->description = $request->get("description",'');
            $lobusiness->is_active = $request->get("is_active",'');
            $lobusiness->save();
            $message = 'Line Of Business successfully'.($id == '' ? ' added' : ' updated');
            \Session::flash('flash_message',$message);
            return redirect(action('Admin\LOBusinessController@index'));
        }catch(\Exception $ex){

           //LogActivity::addToLog(trans('admin.lobusiness_'.($id == '' ? 'create' : 'edit').'_error_log').$ex->getMessage());
           return redirect(action('Admin\LOBusinessController@index'))->with('error', $ex->getMessage());
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $lobusiness = LOBusiness::findOrFail($id);
        $state_list = DB::table('state')->where('country_id' , 99)->get();
        return view('Admin.LOBusiness.edit', compact(
            'lobusiness', 'state_list'
        ));
    }

    public function destroy($id)
    {
        try {
            $lobusiness = LOBusiness::findOrFail($id);
            $lobusiness->delete();
            return response()->json(['success' => true, 'status_code' => '1']);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage(), 'success' => false, 'status_code' => '0']);
        }
    }
}
