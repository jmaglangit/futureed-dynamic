<?php namespace FutureEd\Models\Core;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model {

	//

    protected $table = 'grades';

    protected $dates = ['deleted_at'];

    protected $fillable = ['country_id', 'name', 'description', 'code','status','created_by','updated_by'];

    protected $hidden = ['created_by','updated_by','created_at','updated_at','deleted_at'];


    public static $rules = array(
		'country_id' => 'required|integer',
		'name' => 'required',
		'status' => 'required|in:Enabled,Disabled'
	);


    public function students() {

        return $this->hasMany('FutureEd\Models\Core\Student','grade_code','code');
    }

}
