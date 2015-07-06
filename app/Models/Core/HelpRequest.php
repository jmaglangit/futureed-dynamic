<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HelpRequest extends Model {

    use SoftDeletes;

    protected $table = 'help_requests';

    protected $dates = ['deleted_at','last_answered_at','created_at', 'updated_at'];

    protected $hidden = ['created_by', 'updated_by', 'updated_at', 'deleted_at'];

    protected $fillable =['class_id','student_id','title','content','module_id','subject_id','subject_area_id','link_type','link_id', 'request_status','status','question_status','last_answered_at'];

    protected $attributes = [   'created_by' => 1,
                                'updated_by' => 1,
                                'module_id'=> 0,
                                'subject_id'=> 0,
                                'subject_area_id' => 0,
                                'link_type' => 'General',
                                'link_id'=> 0,
                                'request_status' => 'Pending',
                                'status' =>'Enabled',
                                'question_status' => 'Open'  ];

    //Relationships
    public function classroom(){
        return $this->belongsTo('FutureEd\Models\Core\Classroom','class_id','id');
    }

    public function module(){
        return $this->belongsTo('FutureEd\Models\Core\Module');
    }

    public function subject(){
        return $this->belongsTo('FutureEd\Models\Core\Subject');
    }

    public function subjectArea(){
        return $this->belongsTo('FutureEd\Models\Core\SubjectArea');
    }

    public function student(){
        return $this->belongsTo('FutureEd\Models\Core\Student');
    }

    //Scopes
    public function scopeModuleName($query, $module) {
        return $query->whereHas('module', function($query) use ($module) {
            $query->name($module);
        });
    }

    public function scopeSubjectName($query, $subject) {
        return $query->whereHas('subject', function($query) use ($subject) {
            $query->name($subject);
        });
    }

    public function scopeSubjectAreaName($query, $subject_area) {
        return $query->whereHas('subjectArea', function($query) use ($subject_area) {
            $query->name($subject_area);
        });
    }

    public function scopeStatus($query, $status){
        return $query->where('status',$status);
    }

    public function scopeStudentName($query, $student_name) {
        return $query->whereHas('student', function($query) use ($student_name) {
            $query->name($student_name);
        });
    }

    public function scopeNotRejected($query){
        return $query->whereNotIn('request_status',[config('futureed.help_request_status_rejected')]);
    }

    public function scopeTitle($query,$title){
        return $query->where('title','like','%'.$title.'%');
    }

    public function scopeLinkType($query,$link_type){
        return $query->whereLinkType($link_type);
    }

    public function scopeOwnRequest($query,$student_id){
        return $query->whereStudentId($student_id);
    }

    public function scopeOtherRequest($query,$student_id){
        return $query->whereNotIn('student_id',[$student_id]);
    }

    public function scopeSubjectId($query,$subject_id){
        return $query->whereSubjectId($subject_id);
    }

    public function scopeClassId($query,$class_id){
        return $query->whereClassId($class_id);
    }

    public function scopeRequestStatus($query,$request_status){
        return $query->whereRequestStatus($request_status);
    }


}
