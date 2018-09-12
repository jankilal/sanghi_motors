<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Validator;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Validator;

class Model extends Authenticatable
{

    use SoftDeletes;
  
    
    protected $table = 'model';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'id';
    protected $fillable = [ 'model_name', 'model_number','weight','lob_id','model_color','description' ];
    protected $hidden = ["created_at","updated_at"];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    /*protected $hidden = [
        'password', 'remember_token',
    ];*/

    /*protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        return trim($this->attributes['model_name'] . " " .$this->attributes['model_number']);
    }*/
    
    /**
     * Get a validator for user.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function validator(array $data, $id = '')
    {
        return Validator::make($data, [
            'model_name' => 'required|max:255',
            'model_number' => 'required|max:255',
            'is_active' => 'required|max:255',
            'weight' => 'required|max:255',
            'lob_id' => 'required|max:255',
            'model_color' => 'required|max:255',
            
        ]);
    }
    
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    /**
     * Generate RefIdKey for tables used through out the system
     * @param int The useID of the loggedin user
     * @return string Return the generated unique reference idKey
     */
    public function CreateRefId($prefix, $format= '' ,$id = '', $rand1 = true, $rand2 = true)
    {
        $total_count = $this->count();
        if($total_count < 100){
            $total_count_number = 2;
        }else{
            $total_count_number = $total_count+1;
        }
        $prefix_upper = strtoupper($prefix);
        $prefix_short = $prefix_upper;
        $rand1 = $rand1 ? mt_rand(10, 99) : "";
        $rand2 = $rand2 ? mt_rand(10, 99) : "";
        $time1 = time() . $rand2;
        $ref_id = rand(100,999).$id;
        $refidkey = $prefix_short . '-'.date($format) .'/'. $ref_id;
        return ['ref_id'=> $ref_id, 'grievance_ref_id'=>$refidkey];
    }
    
    public function getGrievanceDateAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }
}
