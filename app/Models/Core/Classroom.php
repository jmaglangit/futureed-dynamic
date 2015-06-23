<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classroom extends Model {

	//
    use SoftDeletes;

    protected $table = 'classrooms';

    protected $dates = ['deleted_at'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

    protected $fillable = ['order_no','name','grade_id','client_id','seats_taken','seats_total','status'];


    //Relationships

    public function order(){

        return $this->hasOne('FutureEd\Models\Core\Order','order_no','order_no');
    }

    public function client(){

        return $this->belongsTo('FutureEd\Models\Core\Client');
    }

    public function grade(){

        return $this->belongsTo('FutureEd\Models\Core\Grade');
    }

    public function students(){

        return $this->belongsTo('FutureEd\Models\Core\ClassStudent');
    }


    //Scopes

    public function scopeName($query, $name){

        return $query->where('name','like','%'.$name.'%');
    }

    public function scopeGrade_Id($query,$grade_id){

        return $query->where('grade_id',$grade_id);
    }

    public function scopeId($query, $id){

        return $query->where('id',$id);
    }

    public function scopeOrder_No($query,$order_no){

        return $query->where('order_no',$order_no);
    }

	public function scopeClient_Id($query, $client_id){

		return $query->where('client_id',$client_id);
	}



    


}
