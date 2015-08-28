<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceDetail extends Model {

	use SoftDeletes;

    protected $table = 'invoice_details';

    protected $dates = ['deleted_at'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];
    
    protected $fillable = ['invoice_id', 'class_id', 'grade_id','price','created_by','updated_by'];

    protected $attributes = ['created_by' => 1,'updated_by' =>1];

    public function classroom() {

        return $this->belongsTo('FutureEd\Models\Core\Classroom','class_id','id')->with('client','subject','classStudent');
    }

    public function invoice(){

        return $this->BelongsTo('FutureEd\Models\Core\Invoice','invoice_id','id');


    }

    public function grade() {

        return $this->belongsTo('FutureEd\Models\Core\Grade');

    }

    public function scopeInvoiceId($query,$invoice_id){
        return $query->where('invoice_id',$invoice_id);
    }

    public function scopeClassId($query,$class_id){
        return $query->where('class_id',$class_id);
    }
    
}
