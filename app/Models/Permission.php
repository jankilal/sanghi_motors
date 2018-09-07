<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;
class Permission extends Model
{
    public static function defaultPermissions()
    {
        return [
            'view_users',
            'add_users',
            'edit_users',
            'delete_users',

            'view_roles',
            'add_roles',
            'edit_roles',
            'delete_roles',
        ];
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

    public function role()
    {
        return $this->belongsToMany('App\Models\Role');
    }
}
