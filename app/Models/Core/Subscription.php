<?php namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model {

    use SoftDeletes;

	use TransactionTrait;
    
	protected $table = 'subscription';
	
	protected $dates = ['deleted_at'];
	
	protected $fillable = ['name', 'description', 'status','created_by','updated_by', 'has_lsp'];
	
    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];

    protected $casts = [
        'has_lsp' => 'integer',
    ];

    //-------------scopes
	public function scopeName($query, $name) {
		
		return $query->where('name', 'like', '%'.$name.'%');
				
	}

	public function scopeStatus($query,$status){
		return $query->where('status',$status);
	}
}
