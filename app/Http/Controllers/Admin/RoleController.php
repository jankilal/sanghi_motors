<?php

namespace App\Http\Controllers\Admin;
use App\Helpers\LogActivity;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Action;
use App\Models\ActionRole;
use App\Models\Section;
use App\Models\Role;
use Illuminate\Http\Request;
use DataTables;
use Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();
        return view('Admin.role.index', compact( 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Section::where('is_active','Active')->get();
        $actions = Action::whereNotIn('id', array(8))->get();
        $action_arr = [];
        
        $permissions = Permission::all();
        $user_permissions = Auth::user()->role->permissions()->get();
        $rolePermissions = [];
        return view('Admin.role.form', compact('user_permissions','permissions','rolePermissions', 'sections', 'actions', 'action_arr'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $id = $request->get("id", '');
        $validator = Role::validator($request->all(), $id);
        if($validator->fails()) {
            // throw errors
            return redirect()->back()
                ->withErrors($validator->getMessageBag())
                ->withInput($request->all());
        }
        if($id == '') 
        {
            $role = new Role();
        } else 
        {
            $role = Role::findOrFail($id);
            $user = Auth::user();

            if($role->is_admin != 2 && $user->role_id != $role->id)
            {
                return redirect(action('Admin\RoleController@index'))->with('error', 'You can not update System Admin / User');
            }
        }
        $role->name = $request->get("name",'');
        $role->role_label = $request->get("name",'');
        $role->is_system_role = 1;
        $role->is_admin = 2;
        $role->save();

        // Set Role Permissions
        $permissions = $request->get('permission', []);
        $role->permissions()->sync($permissions);
        
        // set permissions for section and retaled actions 
        $action_permissions = $request->get('action_permission', []);
        $this->save_action($role->id,  $action_permissions);
        
      
        $message = trans('admin.role_'.($id == '' ? 'add' : 'edit').'_success_msg');
        LogActivity::addToLog(trans('admin.role_'.($id == '' ? 'create' : 'edit').'_log').$role->id);
        
        return redirect(action('Admin\RoleController@index'))->with('success', $message);
    }
    
    public function save_action($id,  $action_permissions)
    {
        // delete all previous entries
        DB::table('action_role')->where('role_id', '=', $id)->delete();
        
        for($i=0; $i<sizeof($action_permissions); $i++)
        {
            $str = $action_permissions[$i];
            $component = explode('-', $str);
            
            DB::table('action_role')->insert( ['role_id' => $id, 'section_id' => $component[0] , 'action_id' => $component[1] ] );
        }
        return 1;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sections = Section::all();
        $actions = Action::whereNotIn('id', array(8))->get();
        
        $action_arr = [];
        $action_permissions = DB::table('action_role')->where('role_id', $id)->get();
        foreach ($action_permissions as $ap) 
        {
             $str = $ap->section_id.'-'.$ap->action_id;
             array_push($action_arr, $str);
        }
       
        $permissions =  $permissions = Permission::all();
        $role = Role::with('permissions')->findOrFail($id);
        $rolePermissions = $role->permissions()->pluck("permission_id")->toArray();
        return view('Admin.role.form', compact('role', 'permissions', 'rolePermissions', 'sections', 'actions', 'action_arr'));
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        if($role = Role::findOrFail($id)) {
            // admin role has everything
            if($role->name === 'Admin') {
                $role->syncPermissions(Permission::all());
                return redirect()->route('roles.index');
            }

            $permissions = $request->get('permissions', []);
            $role->syncPermissions($permissions);
            flash( $role->name . ' permissions has been updated.');
        } else {
            flash()->error( 'Role with id '. $id .' note found.');
        }

        return redirect()->route('roles.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $role = Role::findOrFail($id);
            $count_associate_user = $role->users()->get()->count();
            if($count_associate_user > 0){
                LogActivity::addToLog(trans('admin.role_delete_error_log').@$role->name);
                return response()->json(['error' => 'You can not delete this Role because this roles is in use.']);
            }else{
                LogActivity::addToLog(trans('admin.role_delete_log').@$role->name);
                $role->forceDelete();
                return response()->json(['success' => true]);
            }

        } catch (\Exception $ex) {
            LogActivity::addToLog(trans('admin.role_delete_error_log').@$role->name);
            return response()->json(['error' => $ex->getMessage()]);
        }
    }

    /**
     * Process datatables ajax request.
     * @return \Illuminate\Http\JsonResponse
     */
    public function anyData()
    {
        return Datatables::of(Role::orderBy('id','desc')->get())
            ->addColumn('name', function($role){
                if(strtolower($role->name) == 'users'){
                    return 'User';
                }else{
                    return $role->name;
                }
            })
            ->addColumn('action', function ($role) {
                
                if($role->is_admin == 2)
                {
                    $btnStr = '';
                    if(in_array('roles.edit', Session::get('Permissions')))
                    {
                      $btnStr .= '<a href="'. action('Admin\RoleController@edit',[$role->id]).'"class="btn btn-xs btn-primary"><i class="fa fa-pencil-square-o"></i> Edit</a>&nbsp;';
                    }
                    if($role->name != 'Super Admin')
                    {
                      $btnStr .= '<a href="'. action('Admin\RoleController@destroy',[$role->id]) . '" data-id="'. $role->id . '" class="btn btn-xs btn-primary btn-delete">'.'<i class="fa fa-trash"></i> Delete</a>';
                    }
                    return $btnStr;
                }else{

                    $btnStr = '';
                    if(strtolower($role->name) == 'users'){
                        $user_permission = \Config::get('DevConfig.users_permission');
                        $btnStr.="<a href='javascript:void(0);' data-jsondata='".json_encode($user_permission)."' id='view-up' class='btn btn-xs btn-primary view-trans'><i class=\"fa fa-eye\"></i> View</a>";
                    }
                    return $btnStr;
                }
            })
            ->make(true);
    }
}
