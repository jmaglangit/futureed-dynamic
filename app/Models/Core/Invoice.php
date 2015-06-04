<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model {

	use SoftDeletes;
	
    protected $table = 'invoices';

    protected $dates = ['deleted_at'];
    
    protected $fillable = ['order_no', 'invoice_date', 'invoice_no', 'client_id','client_name','date_start','date_end','seats_total','discount_type','discount_id','discount','total_amount','subscription_id','payment_status'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];	
    
    //-------------relationships
    
	public function client() {
		return $this->belongsTo('FutureEd\Models\Core\Client');
	}

    public function discount(){
        return $this->morphToMany('FutureEd\Models\Core\ClientDiscount','FutureEd\Models\Core\ClientDiscount');
    }
    
    public function subscription() {
        return $this->belongsTo('FutureEd\Models\Core\Subscription');
    }
    
    public function order(){
        return $this->hasOne('FutureEd\Models\Core\Order');
    }
    
    public function invoiceDetail(){
        return $this->hasOne('FutureEd\Models\Core\InvoiceDetail');
    }

    //------------scopes    
    public function scopeOrder($query, $order_no) {

        return $query->where('order_no', '=' , $order_no);

    }

    public function scopeSubscription($query, $sub_id) {

        return $query->where('subscription_id', '=' , $sub_id);

    }

    public function scopePayment($query, $payment_status) {

        return $query->where('payment_status', '=' , $payment_status);

   }

    
}
