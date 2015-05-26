<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model {

    use SoftDeletes;

    protected $table = 'grades';

    protected $dates = ['deleted_at'];

    protected $fillable = ['country_id', 'name', 'description', 'code','status','created_by','updated_by'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];


    public static $rules = array(
		'country_id' => 'required|integer',
		'name' => 'required',
		'status' => 'required|in:Enabled,Disabled'
	);


    //Relationships

    public function students() {

        return $this->hasMany('FutureEd\Models\Core\Student','grade_code','code');
    }

    public function country(){

        return $this->belongsTo('Webpatser\Countries\Countries');
    }



    //Scopes

    public function scopeName($query, $name) {

        return $query->where('name', 'like' , '%'.$name.'%');

    }

    public function scopeCountryId($query,$country_id){

        return $query->where('country_id', '=', $country_id);
    }





}
