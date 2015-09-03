<?php namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HelpRequestAnswerRating extends Model {

    use SoftDeletes;

	use TransactionTrait;

    protected $table = 'help_request_answer_ratings';

    protected $dates = ['created_at','updated_at','deleted_at'];

    protected $hidden = ['updated_by','created_at','deleted_at'];

    protected $fillable = ['student_id','help_request_answer_id','rating','comments'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];

    //Relationships

    public function student(){
        return $this->belongsTo('FutureEd\Models\Core\Student');
    }

    public function helpRequestAnswer(){
        return $this->belongsTo('FutureEd\Models\Core\HelpRequestAnswer');
    }

    //Scopes

    public function scopeStudentId($query,$student_id){
        return $query->whereStudentId($student_id);
    }

    public function scopeHelpRequestAnswerId($query,$student_id){
        return $query->whereHelpRequestAnswerId($student_id);
    }

}
