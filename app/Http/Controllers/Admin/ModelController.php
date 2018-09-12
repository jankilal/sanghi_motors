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
use App\Models\Model;
use App\Models\LOBusiness;
use Illuminate\Support\Facades\DB;
use Session;

class ModelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $data = [''];
        return view('Admin.Model.index',compact('data'));
    }

    public function create(){

        $lob_list = ['' => 'Select LOB'] + DB::table('line_of_business')->where('is_active' , 'Active')->pluck('name' , 'id')->toArray();
        return view('Admin.Model.add',compact('lob_list'));
    }

    public function UnauthorizedAccess(){
        $data = [];
        return view('Admin.ErrorPage.unauthorized_access',compact('data'));
    }

    public function loadModelData(){

        return Datatables::of(Model::select('*'))
            ->addColumn('action', function ($loct) {
                $btnStr = '';
                $btnStr .= '<a  href="'. route('model.edit',array($loct->id)) . '" data-id="'. $loct->id . '" class="btn btn-xs btn-btn btn-dark pull btn-edit"><i class="fa fa-pencil-square-o"></i> Edit</a>';
                // $btnStr .= '<a onclick="return myFunction();" data-href="'. route('model.destroy',array($loct->id)) . '" data-id="'. $loct->id . '" class="btn btn-xs btn-danger btn-delete"><i class="fa fa-trash"></i> Delete</a>';
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
            $validator = Model::validator($request->all(), $id);
            if($validator->fails()) {
                // throw errors
                return redirect()->back()
                    ->withErrors($validator->getMessageBag())
                    ->withInput($request->all());
            }
            if($id == '') 
            {
                $model = new Model();
            } 
            else 
            {
                $model = Model::findOrFail($id);
            }
            $model->model_name = $request->get("model_name",'');
            $model->model_number = $request->get("model_number",'');
            $model->weight = $request->get("weight",'');
            $model->lob_id = $request->get("lob_id",'');
            $model->model_color = $request->get("model_color",'');
            $model->description = $request->get("description",'');
            $model->is_active = $request->get("is_active",'');
            $model->save();
            $message = 'Model successfully'.($id == '' ? ' added' : ' updated');
            \Session::flash('flash_message',$message);
            return redirect(action('Admin\ModelController@index'));
        }catch(\Exception $ex){

           //LogActivity::addToLog(trans('admin.model_'.($id == '' ? 'create' : 'edit').'_error_log').$ex->getMessage());
           return redirect(action('Admin\ModelController@index'))->with('error', $ex->getMessage());
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $model = Model::findOrFail($id);
        $lob_list = LOBusiness::orderBy('name','ASC')->where('is_active' , 'Active')->get();
        return view('Admin.Model.edit', compact(
            'model', 'lob_list'
        ));
    }

    public function destroy($id)
    {
        try {
            $model = Model::findOrFail($id);
            $model->delete();
            return response()->json(['success' => true, 'status_code' => '1']);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage(), 'success' => false, 'status_code' => '0']);
        }
    }
}
