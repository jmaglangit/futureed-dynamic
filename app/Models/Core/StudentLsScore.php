<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use FutureEd\Models\Traits\TransactionTrait;

class StudentLsScore extends Model {

	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'student_ls_scores';

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

	protected $fillable = ['student_id', 'ls_test_id', 'ls_group', 'ls_name', 'ls_seq_no', 'ls_std_score', 'ls_percentile', 'ls_banding'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];
	
	
	//-- Scopes
	public function scopeStudent_id($query, $student_id) {
		return $query->where('student_id', '=', $student_id);
	}
    
    public function scopeTest_id($query, $ls_test_id) {
    	return $query->where('ls_test_id', '=', $ls_test_id);
    }
    
    public function scopeName($query, $name) {
    	return $query->whereLsName($name);
    }
}