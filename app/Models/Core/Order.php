<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model {

    use SoftDeletes;

    protected $table = 'orders';

    protected $dates = ['deleted_at'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

    protected $fillable = ['order_no','order_date','client_id','subscription_id','date_start','date_end','seats_total','seats_taken','total_amount','payment_status','student_id'];



    public function scopeOrderNo($query,$order_no){
        return $query->where('order_no',$order_no);
    }
}