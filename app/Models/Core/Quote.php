<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model {

    use SoftDeletes;

    protected $table = 'quotes';

    protected $hidden = ['created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

    protected $fillable =['quote','percent','answer_status','seq_no'];


	//relationships
	public function avatarQuote(){
        return $this->hasOne('FutureEd\Models\Core\AvatarQuote');
    }

    //scopes
    public function scopeAvatarId($query, $avatar_id){
        return $query->whereHas('avatarQuote', function ($query) use ($avatar_id) {
			$query->where('avatar_id', '=', $avatar_id);
		});
    }
    
    public function scopePercent($query,$pct){
        return $query->wherePercent($pct);
    }

    public function scopeSeqNo($query,$seq_no){
        return $query->whereSeqNo($seq_no);
    }
}
