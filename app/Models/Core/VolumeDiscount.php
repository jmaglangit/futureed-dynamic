<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VolumeDiscount extends Model {

    use SoftDeletes;

    protected $table = 'volume_discounts';

    protected $dates = ['deleted_at'];

    protected $fillable = ['min_seats', 'percentage', 'status'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1
	];

    //-------------scopes
    public function scopeMinSeats($query, $min_seats) {
        return $query->where('min_seats', 'like', '%'.$min_seats.'%');
    }

    public function scopeFloorMinSeats($query, $min_seats){
        return $query->where('min_seats', '<=', $min_seats);
    }
}
