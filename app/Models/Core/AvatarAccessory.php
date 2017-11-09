<?php

namespace FutureEd\Models\Core;
use FutureEd\Models\Core\Student;
use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AvatarAccessory extends Model {

	//id,code,name,avatar_id,accessory_image,points_to_unlock,description,created_by,updated_by,deleted_at,created_at,updated_at

	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'avatar_accessories';

	protected $hidden = ['created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

	protected $fillable = ['avatar_id','code','name','accessory_image','description'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];

	//-----scope
	// Returns a list of avatar accessories based on the provided avatar id
	public function scopeAvatarAccessories($query,$avatar_id){
		return $query->whereAvatarId($avatar_id);
	}


}