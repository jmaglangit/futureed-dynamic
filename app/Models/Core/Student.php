<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model {


    use SoftDeletes;

    protected $table = 'students';

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'password_image_id',
        'point_level_id',
        'learning_style_id',
//        'user_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at'];



    //-------------relationships
    public function user() {
        return $this->belongsTo('FutureEd\Models\Core\User');
    }

    public function school(){

        return $this->belongsTo('FutureEd\Models\Core\School','school_code','code');
    }

    public function grade(){

        return $this->belongsTo('FutureEd\Models\Core\Grade','grade_code','code');
    }

    //-------------scopes
    public function scopeName($query, $name) {

        return $query->where(function($query) use ($name) {
            $query->where('first_name', 'like', '%'.$name.'%')->orWhere('last_name', 'like', '%'.$name.'%');
        });

    }

    public function scopeEmail($query, $email) {

        return $query->whereHas('user', function($query) use ($email) {
            $query->whereEmail($email);
        });

    }


}
