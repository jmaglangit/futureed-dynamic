<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediaType extends Model {

	use SoftDeletes;

    protected $table = 'media_types';

    protected $date = ['created_at','updated_at','deleted_at'];

    protected $hidden = ['created_by', 'updated_by', 'created_at', 'updated_at','deleted_at'];

    protected $fillable = ['name', 'description'];

    protected $attributes = ['created_by' => 1, 'updated_by' => 1];
}
