<?php namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModuleCountry extends Model{

	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'module_countries';

	protected $dates = ['created_at','updated_at','deleted_at'];

	protected $fillable = [
		'module_id',
		'country_id',
		'grade_id'
	];

	protected $hidden = [
		'created_by',
		'updated_by',
		'created_at',
		'updated_at',
		'deleted_at'
	];

	//relationships

	public function grade(){
		return $this->belongsTo('FutureEd\Models\Core\Grade');
	}

	public function module(){
		return $this->belongsTo('FutureEd\Models\Core\Module');
	}

	public function country(){
		return $this->belongsTo('Webpatser\Countries\Countries');
	}

	//scope
	public function scopeSubjectId($query,$subject_id){
		return $query->whereHas('module',function($query) use ($subject_id){
			$query->where('subject_id',$subject_id);
		});
	}

}