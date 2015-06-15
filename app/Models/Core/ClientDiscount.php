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
        return $this->belongsTo('FutureEd\Models\Core\Client')->with('user');
    }

    //------------scopes

    public function scopeName($query, $name){
        return $query->whereHas('client', function($query) use ($name) {
            $query->where('first_name', 'like', '%'.$name.'%')->orWhere('last_name', 'like', '%'.$name.'%')->orderBy('last_name', 'asc');
        });
    }

    public function scopeRole($query, $role) {
        return $query->whereHas('client', function($query) use ($role) {
            $query->whereClientRole($role);
        });
    }

    public function scopeClientId($query,$client_id){
        return $query->where('client_id',$client_id);
    }

	public function scopeClientId($query, $client_id){

		return $query->where('client_id', $client_id);
	}

}
