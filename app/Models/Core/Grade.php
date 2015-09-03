<?php namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model {

    use SoftDeletes;

	use TransactionTrait;

    protected $table = 'grades';

    protected $dates = ['deleted_at'];

    protected $fillable = ['country_id', 'name', 'description', 'code','status','created_by','updated_by'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1,
	];


    public static $rules = array(
		'country_id' => 'required|integer',
		'name' => 'required',
		'status' => 'required|in:Enabled,Disabled'
	);

	//Mutators
	public function setDescriptionAttribute($value){

		if($value == NULL){
			$this->attributes['description'] = 'None';
		} else {
			$this->attributes['description'] = $value;
		}
	}


    //Relationships

    public function students() {

        return $this->hasMany('FutureEd\Models\Core\Student','grade_code','code');
    }

    public function country(){

        return $this->belongsTo('Webpatser\Countries\Countries');
    }

	public function countryGrade(){

		return $this->belongsTo('FutureEd\Models\Core\CountryGrade','id','grade_id')->with('ageGroup');
	}





    //Scopes

    public function scopeName($query, $name) {

        return $query->where('name', 'like' , '%'.$name.'%');

    }

    public function scopeCountryId($query,$country_id){

        return $query->where('country_id', '=', $country_id);
    }


    //-------------relationships classroom
    public function classroom() {
        return $this->hasMany('FutureEd\Models\Core\Classroom');
    }





}
