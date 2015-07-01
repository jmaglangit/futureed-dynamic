<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;

class Module extends Model {

    protected $table = 'modules';

    //Scopes
    public function scopeName($query, $name) {

        return $query->where('name', 'like', '%'.$name.'%');

    }
}
