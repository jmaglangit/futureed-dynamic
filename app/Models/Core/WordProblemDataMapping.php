<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/22/17
 * Time: 2:27 PM
 */

namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WordProblemDataMapping extends Model {

	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'word_problem_data_mapping';

	protected $date = ['deleted_at'];

	protected $fillable = [
		'data'
	];

	protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];

}