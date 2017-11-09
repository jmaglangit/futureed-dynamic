<?php

namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model {

	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'announcements';

	protected $dates = ['deleted_at'];

	protected $hidden = ['created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];
}
