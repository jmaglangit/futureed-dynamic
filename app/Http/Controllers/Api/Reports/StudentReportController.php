<?php namespace FutureEd\Http\Controllers\Api\Reports;

use FutureEd\Http\Requests;

use FutureEd\Models\Repository\Avatar\AvatarRepositoryInterface;
use FutureEd\Models\Repository\ClassStudent\ClassStudentRepositoryInterface;
use FutureEd\Models\Repository\Grade\GradeRepositoryInterface;
use FutureEd\Models\Repository\Module\ModuleRepositoryInterface;
use FutureEd\Models\Repository\PointLevel\PointLevelRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Http\Requests\Api\StudentReportRequest;
use FutureEd\Models\Repository\StudentBadge\StudentBadgeRepositoryInterface;
use FutureEd\Models\Repository\StudentModule\StudentModuleRepository;
use FutureEd\Models\Repository\StudentModule\StudentModuleRepositoryInterface;
use FutureEd\Models\Repository\SubjectArea\SubjectAreaRepository;
use FutureEd\Models\Repository\Tip\TipRepositoryInterface;
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

	protected $tip;

	protected $point_level;

	protected $student_badges;


	/**
	 * StudentReportController constructor.
	 * @param StudentRepositoryInterface $studentRepositoryInterface
	 * @param StudentModuleRepositoryInterface $studentModuleRepositoryInterface
	 * @param AvatarRepositoryInterface $avatarRepositoryInterface
	 * @param ClassStudentRepositoryInterface $classStudentRepositoryInterface
	 * @param GradeRepositoryInterface $gradeRepositoryInterface
	 * @param ModuleRepositoryInterface $moduleRepositoryInterface
	 * @param AvatarServices $avatarServices
	 * @param StudentServices $studentServices
	 * @param SubjectAreaRepository $subjectAreaRepository
	 * @param TipRepositoryInterface $tipRepositoryInterface
	 * @param PointLevelRepositoryInterface $pointLevelRepositoryInterface
	 * @param StudentBadgeRepositoryInterface $studentBadgeRepositoryInterface
	 * @internal param StudentModuleRepository $studentModuleRepository
	 * @internal param $student
	 */
	public function __construct(
		StudentRepositoryInterface $studentRepositoryInterface,
		StudentModuleRepositoryInterface $studentModuleRepositoryInterface,
		AvatarRepositoryInterface $avatarRepositoryInterface,
		ClassStudentRepositoryInterface $classStudentRepositoryInterface,
		GradeRepositoryInterface $gradeRepositoryInterface,
		ModuleRepositoryInterface $moduleRepositoryInterface,
		AvatarServices $avatarServices,
		StudentServices $studentServices,
		SubjectAreaRepository $subjectAreaRepository,
		TipRepositoryInterface $tipRepositoryInterface,
		PointLevelRepositoryInterface $pointLevelRepositoryInterface,
		StudentBadgeRepositoryInterface $studentBadgeRepositoryInterface
	) {
		$this->student = $studentRepositoryInterface;
		$this->class_student = $classStudentRepositoryInterface;
		$this->avatar = $avatarRepositoryInterface;
		$this->grade = $gradeRepositoryInterface;
		$this->module = $moduleRepositoryInterface;
		$this->student_module = $studentModuleRepositoryInterface;
		$this->avatar_service = $avatarServices;
		$this->student_service = $studentServices;
		$this->subject_areas = $subjectAreaRepository;
		$this->tip = $tipRepositoryInterface;
		$this->point_level = $pointLevelRepositoryInterface;
		$this->student_badges = $studentBadgeRepositoryInterface;
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
	 * @param $id - student_id
	 * @param $subject_id
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @internal param StudentReportRequest $request
	 */
	public function getStudentProgressReport($id,$subject_id){

		//automate class students current class.
		$this->student_service->getCurrentClass($id);

		//get student id and subject id

		$student = $this->student->getStudent($id);

		$avatar = $this->avatar->getAvatar($student->avatar_id);

		//earned_badges
		$badge = $this->student_badges->getStudentBadges([
			'student_id' => $id
		]);

		$student_badge = $badge['total'];

		//earned_medals
		$point_level =  $this->point_level->findPointsLevel($this->student->getStudentPoints($id));
		$student_medal = ($point_level) ? $point_level->id : 0;

		//completed_lessons
		$lessons = $this->class_student->getStudentModulesCompleted($id,$subject_id,$student->country_id);

		//written_tips
		$tips = $this->tip->getStudentActiveTips($id,$subject_id);

		//week_hours
		$week_hours = $this->class_student->getStudentModulesWeekHours($id, $subject_id,$student->country_id);

		//total_hours
		$total_hours = $this->class_student->getStudentModulesTotalHours($id, $subject_id,$student->country_id);

		$additional_information = [
			'student_name' => $student->first_name . ' ' . $student->last_name,
			'avatar' => $this->avatar_service->getAvatarUrl($avatar->avatar_image),
			'avatar_thumbnail' => $this->avatar_service->getAvatarThumbnailUrl($avatar->avatar_image),
			'earned_badges' => $student_badge,
			'earned_medals' => $student_medal,
			'completed_lessons' => ($lessons) ? count($lessons->toArray()) : 0,
			'written_tips' => ($tips) ? count($tips->toArray()) : 0,
			'week_hours' => (empty($week_hours)) ? round((($week_hours[0]->total_time/60)/60),1,PHP_ROUND_HALF_UP): 0 ,
			'total_hours' => (empty($total_hours)) ? round((($total_hours[0]->total_time/60)/60),1,PHP_ROUND_HALF_UP): 0,
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

		$header = $this->grade->getGradesByCountries($student_country);;

		$column_header = [];
		$rows = [];

		foreach($header as $column){

			$column_header = array_add($column_header,$column->id,$column->name);
		}

		$column_header = [$column_header];
		//ROWS
		//get each completed on each grades.

		$row_data = $this->class_student->getStudentModulesProgressByGrade($id,$subject_id,$student->country_id);


		foreach($row_data as $data){

			$data->completed = ($data->completed) ? round(($data->completed/$data->module_count) * 100): 0;
			$data->on_going = ($data->on_going) ? round(($data->on_going/$data->module_count) * 100) : 0;
		}

		$data = [
			'progress' => $row_data
		];

		return $this->respondReportData($additional_information, $column_header, $data);
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

		//earned_badges
		$badge = $this->student_badges->getStudentBadges([
			'student_id' => $student_id
		]);

		$student_badge = $badge['total'];

		//earned_medals
		$point_level =  $this->point_level->findPointsLevel($this->student->getStudentPoints($student_id));
		$student_medal = ($point_level) ? $point_level->id : 0;

		//completed_lessons
		$lessons = $this->class_student->getStudentModulesCompleted($student_id,$subject_id,$student->country_id);

		//written_tips
		$tips = $this->tip->getStudentActiveTips($student_id,$subject_id);

		//week_hours
		$week_hours = $this->class_student->getStudentModulesWeekHours($student_id, $subject_id,$student->country_id);

		//total_hours
		$total_hours = $this->class_student->getStudentModulesTotalHours($student_id, $subject_id,$student->country_id);

		$additional_information = [
			'earned_badges' => $student_badge,
			'earned_medals' => $student_medal,
			'completed_lessons' => ($lessons) ? count($lessons->toArray()) : 0,
			'written_tips' => ($tips) ? count($tips->toArray()) : 0,
			'week_hours' => (empty($week_hours)) ? round((($week_hours[0]->total_time/60)/60),1,PHP_ROUND_HALF_UP): 0 ,
			'total_hours' => (empty($total_hours)) ? round((($total_hours[0]->total_time/60)/60),1,PHP_ROUND_HALF_UP): 0,
		];

		$column_header = [['name' => 'Curriculum']];

		$column_header = array_merge($column_header,$grades->toArray());

		$rows = $row_data;



		return $this->respondReportData($additional_information,$column_header,$rows);

	}

	/**
	 * Get Students current learning.
	 * @param $student_id
	 * @param $subject_id
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getStudentCurrentLearning($student_id,$subject_id){

		//automate class students current class.
		$this->student_service->getCurrentClass($student_id);

		//Get student details
		$student = $this->student->getStudent($student_id);

		//check valid class subject.
		$class = $this->class_student->getStudentValidClassBySubject($student_id,$subject_id);

		//get grades collection
		$grades = $this->grade->getGradesByCountries($student->country_id);


		$country_id  = (empty($this->grade->checkCountry($student->country_id)))
			? config('futureed.default_country') : $student->country_id;

		//Get student current learning
		$current_learning = $this->class_student->getStudentCurrentLearning($student_id,$subject_id,$country_id);

		$addition_information = [];

		$column_header = [
			'grade_level' => 'Grade Level',
			'curriculum_category' => 'Curriculum Category',
			'percent_completed' => 'Percent Completed'
		];

		$rows = $current_learning;

		return $this->respondReportData($addition_information,$column_header,$rows);
	}


}
