<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeachingContent extends Model {

    use SoftDeletes;

    protected $table = 'teaching_contents';

    protected $date = ['created_at','updated_at','deleted_at'];

    protected $hidden = ['created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

    protected $fillable = ['module_id', 'subject_id', 'subject_area_id', 'code', 'teaching_module', 'description', 'learning_style_id', 'content_url', 'media_type_id'];

    protected $attributes = ['created_by' => 1, 'updated_by' => 1];

    //Relationships

    public function learningStyle(){
        return $this->belongsTo('FutureEd\Models\Core\LearningStyle');
    }

    public function mediaType(){
        return $this->belongsTo('FutureEd\Models\Core\MediaType');
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

    public function scopeTeachingModule($query,$teaching_module){
        return $query->where('teaching_module','like','%'.$teaching_module.'%');
    }

    public function scopeLearningStyleId($query,$learning_style_id){
        return $query->whereLearningStyleId($learning_style_id);
    }

}
