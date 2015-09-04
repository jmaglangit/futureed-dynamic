<?php namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'orders';

	protected $dates = ['deleted_at'];

	protected $hidden = ['created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

	protected $fillable = ['order_no', 'order_date', 'client_id', 'subscription_id', 'date_start', 'date_end', 'seats_total', 'seats_taken', 'total_amount', 'payment_status', 'student_id'];

	protected $attributes = [
		'client_id' => 0,
		'created_by' => 1,
		'updated_by' => 1
	];

	public function invoice()
	{
		return $this->belongsTo('FutureEd\Models\Core\Invoice', 'order_no', 'order_no')->with('invoiceDetail');
	}

	public function scopeOrderNo($query, $order_no)
	{
		return $query->where('order_no', $order_no);
	}
}