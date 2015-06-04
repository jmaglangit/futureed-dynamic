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
        'user_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at'];


    //Relationships

    public function user(){

        return $this->belongsTo('FutureEd\Models\Core\User');
    }
}
