<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Avatar extends Model {

    use SoftDeletes;

    protected $table = 'avatars';

    protected $dates = ['deleted_at'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

	protected $fillable = [
		'code',
		'gender',
		'avatar_image',
		'background_image',
		'points_to_unlock',
		'description',
		'created_by',
		'updated_by',
		'created_at',
		'updated_at'
	];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];

}
