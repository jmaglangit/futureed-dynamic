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
    
    public function subscription(){
        return $this->hasOne('FutureEd\Models\Core\Subscription');
    }

    //------------scopes    
    public function scopeOrderNo($query,$order_no){
        return $query->where('order_no','like','%'.$order_no.'%');
    }
    
    public function scopeSubscriptionId($query,$subscription_id){
        return $query->where('subscription_id',$subscription_id);
    }
}