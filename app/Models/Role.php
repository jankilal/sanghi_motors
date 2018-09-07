<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'role_label'
    ];

    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission');
    }

    public function users()
    {
        return $this->hasMany('App\Models\User');
    }
    public static function getDemoUserRoleId() {
        return Role::where('name', '=', 'Registered Demo User')->first()->id;
    }

    /**
     * Get a validator for role.
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function validator(array $data, $id = '')
    {
        return Validator::make($data, [
            'name' => 'required|max:255|unique:roles' . ($id != '' ? ',name,'.$id : '')
        ]);
    }

    public function ActionRole(){
        return $this->hasMany('App\Models\ActionRole','role_id');
    }




}
