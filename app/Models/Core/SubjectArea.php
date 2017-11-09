<?php namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubjectArea extends Model {

	use SoftDeletes;

	use TransactionTrait;

    protected $table = 'subject_areas';

    protected $dates = ['deleted_at'];

	protected $fillable = ['subject_id', 'code', 'name', 'description', 'status'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

    protected $attributes = [
        'created_by' => 1,
        'updated_by' => 1,
        'description' => 'None'
    ];

	//-------------relationships
	public function subject() {
	
		return $this->belongsTo('FutureEd\Models\Core\Subject');
		
	}

    public function modules() {

        return $this->hasMany('FutureEd\Models\Core\Module');
    }

	//-------------scopes
	public function scopeSubjectId($query, $subject_id) {
		
		return $query->whereSubjectId($subject_id);
				
	}
	
	public function scopeName($query, $name) {
		
		return $query->where('name', 'like', '%'.$name.'%');
				
	}

    public function moduleCount() {

        return $this->hasOne('FutureEd\Models\Core\Module')
            ->selectRaw('subject_area_id, count(*) as count')
            ->groupBy('subject_area_id');

    }

}
