<?php namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AvatarQuote extends Model {

    use SoftDeletes;

	use TransactionTrait;

    protected $table = 'avatar_quotes';

    protected $hidden = ['created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['avatar_pose_id','quote_id','avatar_id'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];

	//relationships
	public function avatarPose(){
        return $this->hasOne('FutureEd\Models\Core\AvatarPose');
    }
    
    //scopes

    public function scopeQuoteId($query,$quote_id){
        return $query->whereQuoteId($quote_id);
    }

    public function scopeAvatarId($query,$avatar_id){
        return $query->whereAvatarId($avatar_id);
    }

}
