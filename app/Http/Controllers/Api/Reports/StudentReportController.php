<?php namespace FutureEd\Http\Controllers\Api\Reports;

use FutureEd\Http\Requests;

use FutureEd\Models\Repository\Avatar\AvatarRepositoryInterface;
use FutureEd\Models\Repository\ClassStudent\ClassStudentRepositoryInterface;
use FutureEd\Models\Repository\Grade\GradeRepositoryInterface;
use FutureEd\Models\Repository\Module\ModuleRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Http\Requests\Api\StudentReportRequest;
use FutureEd\Models\Repository\StudentModule\StudentModuleRepository;
use FutureEd\Models\Repository\SubjectArea\SubjectAreaRepository;
use FutureEd\Services\AvatarServices;
use FutureEd\Services\StudentServices;

class StudentReportController extends ReportController {

	protected $student;

	protected $student_service;

	protected $avatar;

	protected $avatar_service;

	protected $class_student;

	protected $grade;

	protected $module;

	protected $student_module;

	protected $subject_areas;


	/**
	 * StudentReportController constructor.
	 * @param StudentRepositoryInterface $studentRepositoryInterface
	 * @param AvatarRepositoryInterface $avatarRepositoryInterface
	 * @param ClassStudentRepositoryInterface $classStudentRepositoryInterface
	 * @param GradeRepositoryInterface $gradeRepositoryInterface
	 * @param ModuleRepositoryInterface $moduleRepositoryInterface
	 * @param StudentRepositoryInterface $studentRepositoryInterface
	 * @param AvatarServices $avatarServices
	 * @param StudentServices $studentServices
	 * @param SubjectAreaRepository $subjectAreaRepository
	 * @internal param StudentModuleRepository $studentModuleRepository
	 * @internal param $student
	 */
	public function __construct(
		StudentRepositoryInterface $studentRepositoryInterface,
		AvatarRepositoryInterface $avatarRepositoryInterface,
		ClassStudentRepositoryInterface $classStudentRepositoryInterface,
		GradeRepositoryInterface $gradeRepositoryInterface,
		ModuleRepositoryInterface $moduleRepositoryInterface,
		StudentRepositoryInterface $studentRepositoryInterface,
		AvatarServices $avatarServices,
		StudentServices $studentServices,
		SubjectAreaRepository $subjectAreaRepository
	) {
		$this->student = $studentRepositoryInterface;
		$this->class_student = $classStudentRepositoryInterface;
		$this->avatar = $avatarRepositoryInterface;
		$this->grade = $gradeRepositoryInterface;
		$this->module = $moduleRepositoryInterface;
		$this->student_module = $studentRepositoryInterface;
		$this->avatar_service = $avatarServices;
		$this->student_service = $studentServices;
		$this->subject_areas = $subjectAreaRepository;
	}


	/**
	 * Get Student status report.
	 * @param $id
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getStudentStatusReport($id){

		$student = $this->student->getStudent($id);

		$avatar = $this->avatar->getAvatar($student->avatar_id);

		$student_grade = $this->grade->getGrade($student->grade_code);

		$additional_information = [
			'student_name' => $student->first_name . ' ' . $student->last_name,
			'grade_level' => $student_grade->name,
			'avatar' => $this->avatar_service->getAvatarUrl($avatar->avatar_image),
			'avatar_thumbnail' => $this->avatar_service->getAvatarThumbnailUrl($avatar->avatar_image)
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
	 * @param $subject_id
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @internal param StudentReportRequest $request
	 */
	public function getStudentProgressReport($id,$subject_id){

		//get student id and subject id

		$student = $this->student->getStudent($id);

		$avatar = $this->avatar->getAvatar($student->avatar_id);


		$additional_information = [
			'student_name' => $student->first_name . ' ' . $student->last_name,
			'avatar' => $this->avatar_service->getAvatarUrl($avatar->avatar_image),
			'avatar_thumbnail' => $this->avatar_service->getAvatarThumbnailUrl($avatar->avatar_image),
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

	/**
	 * @param $student_id
	 * @param $subject_id
	 * @param StudentReportRequest $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getStudentSubjectGradeProgressReport($student_id, $subject_id, StudentReportRequest $request){

		//Get student details
		$student = $this->student->getStudent($student_id);

		//automate class students current class.
		$this->student_service->getCurrentClass($student_id);

		//Get Subject Areas as Curriculumns
		$subject_areas = $this->subject_areas->getAreasBySubjectId($subject_id);

		//check valid class subject.
		$class = $this->class_student->getStudentValidClassBySubject($student_id,$subject_id);

		//get grades collection
		$grades = $this->grade->getGradesByCountries($student->country_id);

		//initiate array.
		$row_data = [];

			//loop to get each data per subject areas.
			foreach($subject_areas as $areas){

				if (!empty($class->toArray())) {

					//get student modules by subject areas
					$curriculum_data = $this->class_student->getStudentSubjectProgressByCurriculum(
						$class[0]->student_id, $areas->id, $class[0]->class_id
					);
				}

				$area = new \stdClass();
				//append to every row of areas
				$curr_data = (!empty($curriculum_data)) ? $curriculum_data : [];

				$area->curriculum_name = $areas->name;

				$area->curriculum_data = $curr_data;

				array_push($row_data,$area);

			}

		$additional_information = [];

		$column_header = [['name' => 'Curriculum']];

		$column_header = array_merge($column_header,$grades->toArray());

		$rows = $row_data;



		return $this->respondReportData($additional_information,$column_header,$rows);

	}


}
