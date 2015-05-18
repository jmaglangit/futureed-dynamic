<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientDiscount extends Model {

	use SoftDeletes;
	
	protected $table = 'client_discounts';
	
	protected $dates = ['deleted_at'];
	
	protected $fillable = ['client_id', 'percentage', 'status'];
	
    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];


    //-------------relationships
	public function client()
	{
		return $this->belongsTo('FutureEd\Models\Core\Client');
	}

}
