<?php namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BackgroundImage extends Model{

	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'background_images';

	protected $hidden = ['created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

	protected $fillable = ['name','filename','status'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];

	//scope
	public function scopeStatus($query, $status){

		return $query->where('status',$status);
	}
}