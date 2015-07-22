<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model {

    use SoftDeletes;

    protected $table = 'quotes';

    protected $hidden = ['created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

    protected $fillable =['quote','percent','answer_status','seq_no'];

    //scopes

    public function scopePercent($query,$pct){
        return $query->wherePercent($pct);
    }

    public function scopeSeqNo($query,$seq_no){
        return $query->whereSeqNo($seq_no);
    }
}
