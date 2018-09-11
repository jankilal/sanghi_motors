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
use App\Models\Location;
use Illuminate\Support\Facades\DB;
use Session;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $data = [''];
        return view('Admin.Location.index',compact('data'));
    }

    public function create(){

        $state_list = DB::table('state')->where('country_id' , 99)->get();
        return view('Admin.Location.add',compact('state_list'));
    }

    public function UnauthorizedAccess(){
        $data = [];
        return view('Admin.ErrorPage.unauthorized_access',compact('data'));
    }

    public function loadLocationData(){

        return Datatables::of(Location::select('locations.*', 'state.state_name')->join('state', 'locations.state_id', '=', 'state.id'))
            ->addColumn('action', function ($loct) {
                $btnStr = '';
                $btnStr .= '<a  href="'. route('location.edit',array($loct->id)) . '" data-id="'. $loct->id . '" class="btn btn-xs btn-primary btn-edit"><i class="fa fa-pencil-square-o"></i> Edit</a>';
               // $btnStr .= '<a onclick="return myFunction();" href="'. route('location.destroy',array($loct->id)) . '" data-id="'. $loct->id . '" class="btn btn-xs btn-danger btn-delete"><i class="fa fa-trash"></i> Delete</a>';
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
            $validator = Location::validator($request->all(), $id);
            if($validator->fails()) {
                // throw errors
                return redirect()->back()
                    ->withErrors($validator->getMessageBag())
                    ->withInput($request->all());
            }
            if($id == '') 
            {
                $location = new Location();
            } 
            else 
            {
                $location = Location::findOrFail($id);
            }
            $location->branch_name = $request->get("branch_name",'');
            $location->city = $request->get("city",'');
            $location->postal_code = $request->get("postal_code",'');
            $location->state_id = $request->get("state_id",'');
            $location->address_line_1 = $request->get("address_line_1",'');
            $location->address_line_2 = $request->get("address_line_2",'');
            $location->added_by = $user->id;
            $location->status = $request->get("status",'');
            $location->save();
            $message = 'Location successfully'.($id == '' ? ' added' : ' updated');
            \Session::flash('flash_message',$message);
            return redirect(action('Admin\LocationController@index'));
        }catch(\Exception $ex){

           //LogActivity::addToLog(trans('admin.location_'.($id == '' ? 'create' : 'edit').'_error_log').$ex->getMessage());
           return redirect(action('Admin\LocationController@index'))->with('error', $ex->getMessage());
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $location = Location::findOrFail($id);
        $state_list = DB::table('state')->where('country_id' , 99)->get();
        return view('Admin.Location.edit', compact(
            'location', 'state_list'
        ));
    }

    public function destroy($id)
    {
        try {
            $location = Location::findOrFail($id);
            $location->delete();
            return response()->json(['success' => true, 'status_code' => '1']);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage(), 'success' => false, 'status_code' => '0']);
        }
    }
}
