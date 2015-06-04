<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceDetail extends Model {

	use SoftDeletes;

    protected $table = 'invoice_details';

    protected $dates = ['deleted_at'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];
    
    protected $fillable = ['invoice_no', 'class_id', 'grade_code'];
}
