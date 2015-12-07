<?php

namespace FutureEd\Models\Core;
use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentAvatarAccessories extends Model {

	// id,
	// user_id,
	// avatar_accessories_id,
	// earned_at,
	// created_by,
	// updated_by,
	// deleted_at,
	// created_at,
	// updated_at,

	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'student_avatar_accessories';

	protected $hidden = ['created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

	protected $fillable = ['user_id','avatar_accessories_id','earned_at', 'created_by', 'updated_by', 'created_at', 'updated_at'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];

	//-----scope
	//Search if a user id already has bought the accessory (avatar_accessory_id)
	public function scopeHasAvatarAccessory($query, $accessory) {
		return $query->where('user_id', '=', $accessory['user_id'])
			->where('avatar_accessories_id', $accessory['avatar_accessories_id']);
	}
}