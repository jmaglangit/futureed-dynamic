<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AvatarWiki extends Model {

	use SoftDeletes;

	protected $table = 'avatar_wikis';

	protected $hidden = ['created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

	protected $fillable = ['avatar_id','code','name','description_full','description_summary','title','source'];

	//scopes
	public function scopeAvatarId($query, $avatar_id){

		return $query->where('avatar_id',$avatar_id);
	}
}
