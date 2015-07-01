<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HelpRequest extends Model {

    use SoftDeletes;

    protected $table = 'help_requests';

    protected $dates = ['deleted_at','last_answered_at','created_at', 'updated_at'];

    protected $hidden = ['created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

    protected $fillable =['class_id','student_id','title','content','module_id','subject_id','subject_area_id','link_type','link_id', 'is_verified','status','question_status','last_answered_at'];

    protected $attributes = ['created_by' => 1, 'updated_by' => 1];

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

}
