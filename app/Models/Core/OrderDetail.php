<?php namespace FutureEd\Models\Core;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model{

    use SoftDeletes;

    protected $table = 'order_details';

    protected $dates = ['deleted_at'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

    protected $fillable = ['order_id','student_id','price','created_by','updated_by'];

    public function student(){
        return $this->belongsTo('FutureEd\Models\Core\Student','student_id','id')->with('user');
    }

    public function order(){
        return $this->belongsTo('FutureEd\Models\Core\Order','order_id','id');
    }

    //-------------scopes

    public function scopeOrderId($query,$order_id){
        return $query->where('order_id',$order_id);
    }

    public function scopeStudentId($query,$student_id){
        return $query->where('student_id',$student_id);
    }
}