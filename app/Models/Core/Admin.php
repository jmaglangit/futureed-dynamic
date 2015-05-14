<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model {


    use SoftDeletes;

    protected $table = 'Admins';

    protected $dates = ['deleted_at'];

    protected $hidden = ['user_id','created_by','updated_by','created_at','updated_at','deleted_at'];

    protected $fillable = ['user_id','first_name','admin_role'];


    /**
     * Inverse relation
     */
    public function user(){

        return $this->belongsTo('FutureEd\Models\Core\User');
    }



}
