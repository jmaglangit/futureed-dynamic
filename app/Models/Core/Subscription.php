<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model {

    use SoftDeletes;
    
	protected $table = 'subscription';
	
	protected $dates = ['deleted_at'];
	
	protected $fillable = ['name', 'price', 'description', 'status'];
	
    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];
    
    //-------------scopes
	public function scopeName($query, $name) {
		
		return $query->where('name', 'like', '%'.$name.'%');
				
	}
}
