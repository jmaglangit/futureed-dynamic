<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classroom extends Model {

	//
    use SoftDeletes;

    protected $table = 'classrooms';

    protected $dates = ['deleted_at'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

    protected $fillable = ['order_no','name','grade_id','client_id','seats_taken','seats_total','status','subject_id','student_id'];


    //Relationships

    public function order(){

        return $this->hasOne('FutureEd\Models\Core\Order','order_no','order_no');
    }

    public function client(){

        return $this->belongsTo('FutureEd\Models\Core\Client')->with('user');
    }

    public function grade(){

        return $this->belongsTo('FutureEd\Models\Core\Grade');
    }

    public function classStudent(){

        return $this->belongsTo('FutureEd\Models\Core\ClassStudent','id','class_id')->with('student');
    }

	public function invoiceDetails(){

		return $this->belongsTo('FutureEd\Models\Core\InvoiceDetail', 'id','class_id');

	}

	public function subject(){

		return $this->hasOne('FutureEd\Models\Core\Subject','id','subject_id');
	}

	public function studentModule(){

		return $this->hasMany('FutureEd\Models\Core\StudentModule','subject_id');
	}

	//Class Student

	public function studentSubject(){

		return $this->hasOne('FutureEd\Models\Core\Subject','id','subject_id');
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

	public function scopeSubject_Id($query, $subject_id){

		return $query->where('subject_id',$subject_id);

	}

	public function scopeActive($query){

		return $query->whereHas('classStudent',function($query){
			$query->where('subscription_status',config('futureed.active'));

		});
	}

	public function scopeStudent_Id($query, $student_id){

		return $query->whereHas('classStudent',function($query) use ($student_id){
			$query->where('student_id',$student_id);

		});
	}

}
