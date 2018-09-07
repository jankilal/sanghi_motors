<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'log_activity';
    protected $fillable = [
        'subject', 'url', 'method', 'ip', 'agent', 'user_id','grievance_id','status_id','action_id'
    ];
    
    public function users()
    {
        return $this->belongsTo('App\Models\User','user_id')->withTrashed();
    }

    public function getUserEmail(){
        $user = $this->users;
        return $user->full_name;
    }

    public function getUserName(){
        $user = $this->users;
        if ($user instanceof User){
            return $user->first_name." ".$user->last_name;
        }
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y H:i:s', strtotime($value));
    }
}
