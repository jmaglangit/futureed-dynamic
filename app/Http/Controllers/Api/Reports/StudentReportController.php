<?php namespace FutureEd\Http\Controllers\Api\Reports;

use FutureEd\Http\Requests;

use FutureEd\Models\Repository\Avatar\AvatarRepositoryInterface;
use FutureEd\Models\Repository\ClassStudent\ClassStudentRepositoryInterface;
use FutureEd\Models\Repository\Grade\GradeRepositoryInterface;
use FutureEd\Models\Repository\Module\ModuleRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Http\Requests\Api\StudentReportRequest;
use FutureEd\Models\Repository\StudentModule\StudentModuleRepository;

class StudentReportController extends ReportController {

	protected $student;

	protected $avatar;

	protected $class_student;

	protected $grade;

	protected $module;

	protected $student_module;


	/**
	 * StudentReportController constructor.
	 * @param StudentRepositoryInterface $studentRepositoryInterface
	 * @param AvatarRepositoryInterface $avatarRepositoryInterface
	 * @param ClassStudentRepositoryInterface $classStudentRepositoryInterface
	 * @param GradeRepositoryInterface $gradeRepositoryInterface
	 * @param ModuleRepositoryInterface $moduleRepositoryInterface
	 * @param StudentModuleRepository $studentModuleRepository
	 * @internal param $student
	 */
	public function __construct(
		StudentRepositoryInterface $studentRepositoryInterface,
		AvatarRepositoryInterface $avatarRepositoryInterface,
		ClassStudentRepositoryInterface $classStudentRepositoryInterface,
		GradeRepositoryInterface $gradeRepositoryInterface,
		ModuleRepositoryInterface $moduleRepositoryInterface,
		StudentRepositoryInterface $studentRepositoryInterface
	) {
		$this->student = $studentRepositoryInterface;
		$this->class_student = $classStudentRepositoryInterface;
		$this->avatar = $avatarRepositoryInterface;
		$this->grade = $gradeRepositoryInterface;
		$this->module = $moduleRepositoryInterface;
		$this->student_module = $studentRepositoryInterface;
	}


	/**
	 * Get Student status report.
	 * @param $id
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getStudentStatusReport($id){

		$student = $this->student->getStudent($id);

		$avatar = $this->avatar->getAvatar($student->avatar_id);

		$additional_information = [
			'student_name' => $student->first_name . ' ' . $student->last_name,
			'avatar' => $avatar->avatar_image
		];

		$column_header = [
			'subject' => 'Subject',
			'status' => 'Status',
			'points_earned' => 'Points Earned'
		];

		$subject_status = $this->class_student->getClassStudentStanding($id);

		$rows = $subject_status->toArray();


		return $this->respondReportData($additional_information, $column_header, $rows);
	}

	/**
	 * @param $id
	 * @param StudentReportRequest $request
	 */
	public function getStudentProgressReport($id,$subject_id){

		//get student id and subject id

		$student = $this->student->getStudent($id);

		$avatar = $this->avatar->getAvatar($student->avatar_id);


		$additional_information = [
			'student_name' => $student->first_name . ' ' . $student->last_name,
			'avatar' => $avatar->avatar_image,
			'lessons_completed' => '',
			'stories_completed' => '',
			'tokens_bank' => '',
			'total_tokens' => '',
			'adventure_friends' => '',
			'carnival_rewards' => ''
		];

		//COLUMN
		//check if student countries.
		$countries = [];
		$grade_countries = $this->grade->getGradeCountries();

		foreach($grade_countries as $grade => $k){

			$countries[] = $k->country_id;
		}

		//check if student country if in the grade countries
		$student_country = (in_array($student->country_id,$countries)) ?
			$student->country_id : config('futureed.default_country');

		$header = $this->module->getModuleGradeByStudentCountry($student_country);

		$column_header = [];
		$rows = [];

		foreach($header as $column){

			$column_header = array_add($column_header,$column->grade_id,$column->grade_name);
			$rows = array_add($rows,$column->grade_id,0);
		}

		//ROWS
		//get each completed on each grades.

		$row_data = $this->class_student->getStudentModulesProgressByGrade($id,$subject_id,$student->country_id);


		foreach($row_data as $data){

			$status_data = [
				'completed' => ($data->completed) ? round(($data->completed/$data->module_count) * 100): 0,
				'on_going' => ($data->on_going) ? round(($data->on_going/$data->module_count) * 100) : 0
			];

			$rows[$data->grade_id] = $status_data;
		}

		return $this->respondReportData($additional_information, $column_header, $rows);


	}


}
