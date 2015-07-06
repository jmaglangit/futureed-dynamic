<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModuleContent extends Model {

	use SoftDeletes;

	protected $table = 'module_contents';

}
