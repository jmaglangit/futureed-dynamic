<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModuleGroup extends Model {

    use  SoftDeletes;

	protected $table = 'module_groups';

    protected $dates = ['created_at','updated_at','deleted_at'];

    protected $hidden = ['updated_by','created_at','deleted_at'];

    protected $fillable = ['age_group_id','module_id','points_earned'];

    //Relationships

    public function ageGroup(){
        return $this->belongsTo('FutureEd\Models\Core\AgeGroup');
    }

    public function module(){
        return $this->belongsTo('FutureEd\Models\Core\Module');
    }

    //Scopes

    public function scopeModuleId($query,$module_id){
        return $query->whereModuleId($module_id);
    }

    public function scopeAgeGroupId($query,$age_group_id){
        return $query->whereAgeGroupId($age_group_id);
    }

    public function scopeModuleName($query,$module_name){
        return $query->whereHas('module',function($query) use ($module_name){
            $query->name($module_name);
        });
    }

}
