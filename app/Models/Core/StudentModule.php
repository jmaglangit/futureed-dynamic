<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentModule extends Model {

	//
    use SoftDeletes;

    protected $table = 'student_modules';

    protected $dates = ['deleted_at'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

    protected $fillable = ['class_id', 'student_id', 'module_id', 'module_status', 'last_viewed_content_id', 'progress', 'date_start'
                           ,'date_end', 'total_time', 'question_counter', 'wrong_counter', 'running_points', 'points_earned','last_answered_question_id'
                           ,'created_by','updated_by'];
    

}
