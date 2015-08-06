<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AvatarPose extends Model {

    use SoftDeletes;

    protected $table = 'avatar_poses';

    protected $hidden = ['created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['avatar_id','code','name','pose_image','description'];
    
	
	//-----scope
	public function scopeAvatarId($query,$avatar_id){
		return $query->whereAvatarId($avatar_id);
	}

}
