<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubjectArea extends Model {

	use SoftDeletes;

    protected $table = 'subject_areas';

    protected $dates = ['deleted_at'];

	protected $fillable = ['subject_id', 'code', 'name', 'description', 'status'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

	//-------------relationships
	public function subject() {
	
		return $this->belongsTo('FutureEd\Models\Core\Subject');
		
	}
	
	//-------------scopes
	public function scopeSubjectId($query, $subject_id) {
		
		return $query->whereSubjectId($subject_id);
				
	}

}
