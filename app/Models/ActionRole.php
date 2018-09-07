<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionRole extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'action_role';
    protected $fillable = [
        'section_id',
        'action_id',
        'role_id'
    ];



    public function SectionUser($id = 0, $logged_user = 0){

        $data = [];
        $roles = $this::where('section_id',$id)->groupBy('role_id')->pluck('role_id');
         if(count($roles)>0){
             foreach ($roles as $role){
                 $UserId = auth()->user()->id;
                 if($UserId == 1){
                     $userdata = User::where('role_id',$role)->where('is_active','Active')->get();
                 }else{
                     $userdata = User::where('role_id',$role)->where('id','!=','1')->where('is_active','Active')->get();
                 }

                 if(count($userdata)>0) {
                     foreach ($userdata as $user) {
                         if($user->id != $logged_user){
                             $udata = $user->toArray();
                             $udata['full_name'] = $udata['first_name']." ".$udata['last_name'];
                             array_push($data, $udata);
                         }

                     }
                 }
             }
         }

         return $data;

    }

    Public function ActionData(){
        return $this->belongsTo('App\Models\Action','action_id');
    }
    Public function SectionData(){
        return $this->belongsTo('App\Models\Section','section_id');
    }



}
