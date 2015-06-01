<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceDetail extends Model {

	 use SoftDeletes;

    protected $table = 'invoice_details';

     protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

    public function classroom() {

        return $this->belongsTo('FutureEd\Models\Core\Classroom','class_id','id');
    }

    public function invoice(){

        return $this->belongsTo('FutureEd\Models\Core\Invoice','invoice_no','invoice_no');

    }





}
