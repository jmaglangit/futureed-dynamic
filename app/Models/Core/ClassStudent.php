<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassStudent extends Model {

	//
    use SoftDeletes;

    protected $table = 'class_students';

    protected $dates = ['deleted_at'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

    //Relationships

    public function user(){

        return $this->hasMany('FutureEd\Models\Core\User');
    }

    public function student(){

        return $this->hasMany(('FutureEd\Models\Core\Student'));
    }

    //Scopes

    public function scopeClassroom($query, $classroom){

        return $query->where('class_id',$classroom);
    }


    public function scopeUsername($query, $username) {

        return $query->whereHas('user', function($query) use ($username) {
            $query->where('username', 'like', '%'.$username.'%');
        });

    }


    //-------------scopes
    public function scopeEmail($query, $email) {

        return $query->whereHas('user', function($query) use ($email) {
            $query->where('email', 'like', '%'.$email.'%');
        });

    }
    

}
