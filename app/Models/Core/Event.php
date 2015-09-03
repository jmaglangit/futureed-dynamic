<?php namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model {

	//
    use SoftDeletes;

	use TransactionTrait;

    protected $table = 'events';

    protected $dates = ['deleted_at'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];


	//scope
	public function scopeName($query, $name) {

		return $query->where('name', 'like' , '%'.$name.'%');

	}
    

}
