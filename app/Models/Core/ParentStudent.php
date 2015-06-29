<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParentStudent extends Model {

    //
    use SoftDeletes;

    protected $table = 'parent_students';

    protected $dates = ['deleted_at'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

    protected $fillable = ['parent_id','student_id','invitation_code','status','created_by','updated_by'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1,
	];

    //-------------relationships
//    public function parent_user() {
//        return $this->belongsTo('FutureEd\Models\Core\User','parent_id','id');
//    }

//    public function student_user() {
//        return $this->belongsTo('FutureEd\Models\Core\User','student_id','id');
//    }

    public function student(){
        return $this->belongsTo('FutureEd\Models\Core\Student','student_id')->with('avatar','user');
    }
    //-------------scopes

    public function scopeParentId($query,$parent_id){
        return $query->where('parent_id',$parent_id);
    }

    public function scopeStudentId($query,$student_id){
        return $query->where('student_id',$student_id);
    }

    public function scopeInvitationCode($query,$invitation_code){
        return $query->where('invitation_code',$invitation_code);
    }
}
