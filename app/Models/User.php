<?php

namespace App\Models;

// use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Validator;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    use SoftDeletes;
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'id';
    protected $fillable = [
        'first_name', 'last_name', 'phone', 'email', 'password', 'remember_token', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','created_at','updated_at','deleted_at','api_token'
    ];

    protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        return trim($this->attributes['first_name'] . " " .$this->attributes['last_name']);
    }
    /**
     * Get a validator for user.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function validator(array $data, $id = '')
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            //'email' => 'required|email|max:255|unique:users' . ($id != '' ? ',email,'.$id : ''),
            'phone_number' => 'required|max:15',
            'password' => ($id == '' ? 'required|confirmed|min:6' : ''),
            'role_id' => 'required'
        ]);
    }
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }


    public function can($permission, $arguments = []) {
        return ($this->role->permissions->where('name', $permission)->count() > 0);
    }

    /*public function findForPassport($identifier) {
        return User::orWhere('email', $identifier)->orWhere('phone_number', $identifier)->where('is_Active', 'Active')->first();
    }*/


    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accessTokens()
    {
        return $this->hasMany(OauthAccessToken::class);
    }
}
