<?php namespace FutureEd\Models\Core;

use Dimsav\Translatable\Translatable;
use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Filesystem\Filesystem;

class Module extends Model
{

	use Translatable;

	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'modules';

	protected $dates = ['deleted_at'];

	protected $hidden = [
		'created_by',
		'updated_by',
		'created_at',
		'updated_at',
		'deleted_at'];

	public $translatedAttributes = ['name','description'];

	protected $fillable = [
		'subject_id',
		'subject_area_id',
		'grade_id',
		'code',
		'name',
		'icon_image',
		'original_icon_image',
		'description',
		'common_core_area',
		'common_core_url',
		'points_to_unlock',
		'points_to_finish',
		'translatable',
		'status',
		'created_by',
		'updated_by'];

	protected $attributes = [
		'created_by' => 1,
		'updated_by' => 1,
		'grade_id' => 0,
		'points_earned' => 0
	];

	//Translation
	public $translationModel = 'FutureEd\Models\Core\ModuleTranslation';

	//Accessors
	/**
	 * Modified database data into a URI.
	 * @param $value
	 * @return string
	 */
	public function getIconImageAttribute($value){

		$filesystem = new Filesystem();

		//get path
		$image_path = config('futureed.icon_image_path_final') .'/'. $this->attributes['id'] . '/'. $value;

		//check path
		if($filesystem->exists($image_path)){
			return asset(config('futureed.icon_image_path_final_public') .'/'. $this->attributes['id'] . '/'. $value);

		} else {

			return 'None';
		}
	}
	//-------------relationships
	public function subject() {
		return $this->belongsTo('FutureEd\Models\Core\Subject');
	}

	public function subjectArea() {
		return $this->belongsTo('FutureEd\Models\Core\SubjectArea');
	}

	public function grade() {
		return $this->belongsTo('FutureEd\Models\Core\Grade')->with('countryGrade');
	}

	public function content() {
		return $this->hasMany('FutureEd\Models\Core\ModuleContent');
	}

	public function question() {
		return $this->hasMany('FutureEd\Models\Core\Question');
	}

	public function studentModule() {
		return $this->hasMany('FutureEd\Models\Core\StudentModule')->with('classroom_order')->notFailed()->validClass();
	}

	public function studentModuleValid() {
		return $this->hasMany('FutureEd\Models\Core\StudentModule')->validClass()->notFailed();
	}




	//Scopes
	public function scopeName($query, $name)
	{

		return $query->where('name', 'like', '%' . $name . '%');

	}

	public function scopeSubjectId($query, $subject_id)
	{

		return $query->where('subject_id', '=',  $subject_id );

	}

	public function scopeGradeId($query, $grade_id)
	{

		return $query->where('grade_id', '=',  $grade_id );

	}

	public function scopeLocale($query,$locale){

		return $query->whereHas('translations',function($query) use ($locale){
			$query->where('locale','=',$locale);
		});
	}

	public function scopeSubjectName($query, $name) {

		return $query->whereHas('subject', function($query) use ($name) {
			$query->where('name','like','%'.$name.'%');
		});

	}

	public function scopeSubjectAreaName($query, $name) {

		return $query->whereHas('subjectArea', function($query) use ($name) {
			$query->where('name','like','%'.$name.'%');
		});

	}

	public function scopeAgeGroup($query, $age_group_id){


		return $query->whereHas('grade', function($query) use ($age_group_id){

			$query->whereHas('countryGrade',function($query) use ($age_group_id){

				$query->where('age_group_id',$age_group_id);
			});
		});

	}

	public function scopeModuleStatus($query, $status)
	{

		return $query->whereHas('studentModule', function ($query) use ($status) {
			$query->where('module_status', '=', $status);
		});
	}

	public function scopeStudentModuleStatus($query,$status){

		return $query->where('module_status',$status);
	}

	public function scopeStudentId($query, $student_id){

		return $query->whereHas('studentModule', function ($query) use ($student_id) {
			$query->where('student_id', '=', $student_id);
		});

	}

	public function scopeClassId($query, $class_id){

		return $query->whereHas('studentModule', function ($query) use ($class_id) {
			$query->where('class_id', '=', $class_id);
		});

	}

	public function scopeLeftJoinStudentModule($query, $criteria){

		return $query->leftJoin(
			'student_modules', function($leftJoin) use ($criteria){
			$leftJoin->on('modules.id','=','student_modules.module_id')
				->where('student_modules.student_id','=',$criteria['student_id'])
				->where('student_modules.class_id','=',$criteria['class_id'])
				->where('student_modules.module_status','<>',config('futureed.module_status_failed'))
				->whereNull('student_modules.deleted_at');
		})->where('modules.subject_id',$criteria['subject_id'])
			->where('modules.status', config('futureed.enabled'));
	}
}
