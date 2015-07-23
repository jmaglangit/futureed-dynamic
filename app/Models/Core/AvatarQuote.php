<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AvatarQuote extends Model {

    use SoftDeletes;

    protected $table = 'avatar_quotes';

    protected $hidden = ['created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['avatar_pose_id','quote_id','avatar_id'];

    //scopes

    public function scopeQuoteId($query,$quote_id){
        return $query->whereQuoteId($quote_id);
    }

    public function scopeAvatarId($query,$avatar_id){
        return $query->whereAvatarId($avatar_id);
    }

}
