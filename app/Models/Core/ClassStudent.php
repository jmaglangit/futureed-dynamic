<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClassStudent extends Model {

	//
    use SoftDeletes;

    protected $table = 'class_students';

    protected $dates = ['deleted_at'];
    
    protected $fillable = ['user_id', 'class_id', 'status', 'verification_code'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];
    
    //-------------relationships
	public function classroom()
	{
		return $this->belongsTo('FutureEd\Models\Core\Classroom');
	}
}
