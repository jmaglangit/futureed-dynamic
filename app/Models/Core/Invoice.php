<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model {

	use SoftDeletes;
	
    protected $table = 'invoices';

    protected $dates = ['deleted_at'];
    
    protected $fillable = ['order_no', 'invoice_date', 'invoice_no', 'client_id','client_name','date_start','date_end','seats_total','discount_type','discount_id','discount','total_amount','subscription_id','payment_status','student_id','student_name'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

	protected $attributes = [
		'client_id' => 0,
		'client_name' => 0,
		'discount_id' => 0,
		'discount' => 0,
		'created_by' => 1,
		'updated_by' => 1
	];
    
    //-------------relationships
    
	public function client() {
		return $this->belongsTo('FutureEd\Models\Core\Client');
	}
    
    public function subscription() {
        return $this->belongsTo('FutureEd\Models\Core\Subscription');
    }
    
    public function order(){
        return $this->belongsTo('FutureEd\Models\Core\Order','order_no','order_no');
    }
    
    public function invoiceDetail(){
        return $this->hasMany('FutureEd\Models\Core\InvoiceDetail')->with('classroom','grade');
    }

    //------------scopes    
    public function scopeOrder($query, $order_no) {

        return $query->where('order_no', '=' , $order_no);

    }

    public function scopeSubscription($query, $name) {

		return $query->whereHas('subscription', function($query) use ($name) {
			$query->where('name', 'like', '%'.$name.'%');
		});

    }

    public function scopePayment($query, $payment_status) {

        return $query->where('payment_status', '=' , $payment_status);

   }
   
   public function scopeClientId($query,$client_id){
	   return $query->where('client_id', $client_id);
   }

   public function scopeId($query,$id)
   {

	   return $query->where('id', $id);

   }

   public function scopeStudentId($query,$student_id){

	   return $query->where('student_id', $student_id);
   }

    
}
