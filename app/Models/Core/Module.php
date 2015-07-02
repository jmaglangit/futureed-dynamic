<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model {

	use SoftDeletes;

    protected $table = 'modules';

    //Scopes
    public function scopeName($query, $name) {

        return $query->where('name', 'like', '%'.$name.'%');

    }
}
