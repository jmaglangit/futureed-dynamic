<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Models\Repository\StudentPoint\StudentPointRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\PointLevel\PointLevelRepositoryInterface;
use Illuminate\Support\Facades\Input;
use FutureEd\Http\Requests\Api\StudentPointRequest;
use FutureEd\Models\Repository\Module\ModuleRepositoryInterface;
use FutureEd\Models\Repository\StudentModule\StudentModuleRepositoryInterface;
use FutureEd\Models\Repository\StudentBadge\StudentBadgeRepositoryInterface;
use FutureEd\Models\Repository\Badge\BadgeRepositoryInterface;


use Illuminate\Http\Request;

class StudentPointController extends ApiController {

	protected $student_point;
	protected $student;
	protected $point_level;
	protected $module;
	protected $student_module;
	protected $student_badge;
	protected $badge;

	public function __construct(
				StudentPointRepositoryInterface $student_point,
				StudentRepositoryInterface $student,
				PointLevelRepositoryInterface $point_level,
				ModuleRepositoryInterface $module,
				StudentModuleRepositoryInterface $student_module,
				StudentBadgeRepositoryInterface $student_badge,
				BadgeRepositoryInterface $badge
				){

		$this->student_point = $student_point;
		$this->student = $student;
		$this->point_level = $point_level;
		$this->module = $module;
		$this->student_module = $student_module;
		$this->student_badge = $student_badge;
		$this->badge = $badge;


	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$criteria = [];
		$limit = 0 ;
		$offset = 0;

		//for student_id
		if(Input::get('student_id')){

			$criteria['student_id'] = Input::get('student_id');
		}

		if(Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}

		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}

		//get Student Points
		return $this->respondWithData($this->student_point->getStudentPoints($criteria , $limit, $offset ));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(StudentPointRequest $request)
	{
		$data = $request->only('student_id','points_earned','module_id');
		$data['event_id'] = 1;

		//get module details
		$module_detail = $this->module->viewModule($data['module_id']);

		$data['description'] = config('futureed.student_point_description').' '. $module_detail['name'];

		//add student points
		$return = $this->student_point->addStudentPoint($data);

		//get student details
		$student_detail = $this->student->viewStudent($data['student_id']);

		$data['points'] = $data['points_earned'] + $student_detail['points'];

		$point_level = $this->point_level->findPointsLevel($data['points']);

		//assign point_level_id
		if($point_level){

			$data['point_level_id'] = $point_level['id'];

		}else{

			$data['point_level_id'] = NULL;
		}

		//count subject module under student grade
		$subject_module_count = $this->module->countSubjectModule($module_detail['subject_id'],$module_detail['grade_id']);

		$criteria = [];
		$criteria['subject_id'] = $module_detail['subject_id'];
		$criteria['grade_id'] = $module_detail['grade_id'];
		$criteria['progress'] = config('futureed.student_progress');
		$criteria['student_id'] = $data['student_id'];
		$subject_student_module_count = $this->student_module->countSubjectModuleDone($criteria);

		//check if all module under a subject is completed then add new badge to student
		if($subject_module_count == $subject_student_module_count){

			//get grade details
			$grade = $module_detail->grade->toArray();
			$age_group_id = $grade['country_grade']['age_group_id'];

			//needed for getting badge_details
			$badge =[];
			$badge['subject_id'] = $module_detail['subject_id'];
			$badge['gender'] = $student_detail['gender'];
			$badge['age_group_id'] = $age_group_id;

			//get completed badge details
			$badge_detail = $this->badge->getCompletedBadges($badge);

			//needed for inserting student_badge
			$student_badge['student_id'] = $data['student_id'];
			$student_badge['badge_id'] = $badge_detail['id'];

			//add student badge
			$this->student_badge->addStudentBadge($student_badge);
		}

		$this->student->updateStudentDetails($data['student_id'],$data);

		return $this->respondWithData(['id' => $return['id']]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return $this->respondWithData($this->student_point->viewStudentPoint($id));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, StudentPointRequest $request)
	{
		$data = $request->only('event_id','description');

		$this->student_point->updateStudentPoint($id,$data);

		return $this->respondWithData($this->student_point->viewStudentPoint($id));
	}

}
