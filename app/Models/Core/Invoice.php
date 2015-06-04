<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model {

    use SoftDeletes;

    protected $table = 'invoices';

    protected $dates = ['deleted_at'];

    protected $fillable = ['order_no', 'invoice_date', 'invoice_no', 'client_id','client_name','date_start','date_end',
                           'seats_total','discount_type','discount_id','discount','total_amount','subscription_id','payment_status','created_by','updated_by'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];



    public function scopeOrder($query, $order_no) {

        return $query->where('order_no', '=' , $order_no);

    }

    public function scopeSubscription($query, $sub_id) {

        return $query->where('subscription_id', '=' , $sub_id);

    }

    public function scopePayment($query, $payment_status) {

        return $query->where('payment_status', '=' , $payment_status);

   }

    public function subscription() {
        return $this->belongsTo('FutureEd\Models\Core\Subscription');
    }
}
