<?php namespace FutureEd\Http\Controllers\Api\Reports;

use Carbon\Carbon;
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
use FutureEd\Models\Repository\Subject\SubjectRepositoryInterface;
use FutureEd\Models\Repository\SubjectArea\SubjectAreaRepository;
use FutureEd\Models\Repository\Tip\TipRepositoryInterface;
use FutureEd\Services\AvatarServices;
use FutureEd\Services\StudentServices;
use FutureEd\Services\ImageServices;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;

class StudentReportController extends ReportController {

	protected $student;

	protected $student_service;

	protected $avatar;

	protected $avatar_service;

	protected $class_student;

	protected $grade;

	protected $module;

	protected $student_module;

	protected $subject;

	protected $subject_areas;

	protected $tip;

	protected $point_level;

	protected $student_badges;

	protected $image_service;


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
	 * @param ImageServices $imageServices
	 * @param SubjectAreaRepository $subjectAreaRepository
	 * @param TipRepositoryInterface $tipRepositoryInterface
	 * @param PointLevelRepositoryInterface $pointLevelRepositoryInterface
	 * @param StudentBadgeRepositoryInterface $studentBadgeRepositoryInterface
	 * @param SubjectRepositoryInterface $subjectRepositoryInterface
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
		ImageServices $imageServices,
		SubjectAreaRepository $subjectAreaRepository,
		TipRepositoryInterface $tipRepositoryInterface,
		PointLevelRepositoryInterface $pointLevelRepositoryInterface,
		StudentBadgeRepositoryInterface $studentBadgeRepositoryInterface,
		SubjectRepositoryInterface $subjectRepositoryInterface
	) {
		$this->student = $studentRepositoryInterface;
		$this->class_student = $classStudentRepositoryInterface;
		$this->avatar = $avatarRepositoryInterface;
		$this->grade = $gradeRepositoryInterface;
		$this->module = $moduleRepositoryInterface;
		$this->student_module = $studentModuleRepositoryInterface;
		$this->avatar_service = $avatarServices;
		$this->student_service = $studentServices;
		$this->image_service = $imageServices;
		$this->subject_areas = $subjectAreaRepository;
		$this->tip = $tipRepositoryInterface;
		$this->point_level = $pointLevelRepositoryInterface;
		$this->student_badges = $studentBadgeRepositoryInterface;
		$this->subject = $subjectRepositoryInterface;
	}


	/**
	 * Get Student status report.
	 * @param $id
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getStudentStatusReport($id) {

		$student = $this->student->getStudent($id);

		$avatar = $this->avatar->getAvatar($student->avatar_id);

		$student_grade = $this->grade->getGrade($student->grade_code);

		$additional_information = [
			'student_name' => $student->first_name . ' ' . $student->last_name,
			'grade_level' => isset($student_grade->name) ? $student_grade->name : config('futureed.none'),
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

		return [
			'additional_information' => $additional_information,
			'column_header' => $column_header,
			'rows' => $rows
		];
	}

	/**
	 * @param $student_id
	 * @param $subject_id
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getStudentProgressReport($student_id, $subject_id) {

		//automate class students current class.
		$this->student_service->getCurrentClass($student_id);

		//get student id and subject id

		$student = $this->student->getStudent($student_id);

		$avatar = $this->avatar->getAvatar($student->avatar_id);

		//automate class students current class.
		$this->student_service->getCurrentClass($student_id);

		//check valid class subject.
		$class = $this->class_student->getStudentValidClassBySubject($student_id,$subject_id,$student->user->curriculum_country);
		$class_ids = [];

		foreach($class as $classes){
			array_push($class_ids,$classes->class_id);
		}

		//earned_badges
		$badge = $this->student_badges->getStudentBadges([
			'student_id' => $student_id
		]);

		$student_badge = $badge['total'];

		//earned_medals
		$point_level = $this->point_level->findPointsLevel($this->student->getStudentPoints($student_id));
		$student_medal = ($point_level) ? $point_level->id : 0;

		//completed_lessons
		$lessons = $this->class_student->getStudentSubjectProgressByCurriculumCompleted($student_id, $subject_id, $class_ids);

		//written_tips
		$tips = $this->tip->getStudentActiveTips($student_id, $subject_id);

		//week_hours

		$criteria = [
			'date_from' => Carbon::now()->addDay(-7)->toDateTimeString(),
			'date_to' => Carbon::now()->toDateTimeString(),
			'country_id' => $student->user->curriculum_country,
			'student_id' => $student_id,
			'class_id' => $class_ids
		];

		$week = $this->student_module->getStudentSpentHours($criteria);

		$week_hours = (empty($week)) ? 0 : Carbon::createFromTimestamp($week->total_time)
			->diffInHours(Carbon::createFromTimestamp(0));

		//total_hours
		$criteria['date_from'] = Carbon::createFromTimestamp(0)->toDateTimeString();

		$hours_spent = $this->student_module->getStudentSpentHours($criteria);

		$total_hours = (empty($hours_spent)) ? 0 : Carbon::createFromTimestamp($hours_spent->total_time)
			->diffInHours(Carbon::createFromTimestamp(0));

		$additional_information = [
			'student_name' => $student->first_name . ' ' . $student->last_name,
			'avatar' => $this->avatar_service->getAvatarUrl($avatar->avatar_image),
			'avatar_thumbnail' => $this->avatar_service->getAvatarThumbnailUrl($avatar->avatar_image),
			'earned_badges' => $student_badge,
			'earned_medals' => $student_medal,
			'completed_lessons' => ($lessons) ? count($lessons->toArray()) : 0,
			'written_tips' => ($tips) ? count($tips->toArray()) : 0,
			'week_hours' => $week_hours,
			'total_hours' => $total_hours
		];

		//COLUMN
		//check if student countries.
		$countries = [];
		$grade_countries = $this->grade->getGradeCountries();

		foreach ($grade_countries as $grade => $k) {

			$countries[] = $k->country_id;
		}

		//check if student country if in the grade countries
		$student_country = (in_array($student->user->curriculum_country, $countries)) ?
			$student->user->curriculum_country : config('futureed.default_country');

		$header = $this->grade->getGradesByCountries($student_country);;

		$column_header = [];
		$rows = [];

		foreach ($header as $column) {

			$column_header = array_add($column_header, $column->id, $column->name);
		}

		$column_header = [$column_header];
		//ROWS
		//get each completed on each grades.

		$row_data = $this->class_student->getStudentModulesProgressByGrade($student_id, $subject_id, $student->user->curriculum_country);


		foreach ($row_data as $data) {

			$data->completed = ($data->completed) ? round(($data->completed / $data->module_count) * 100) : 0;
			$data->on_going = ($data->on_going) ? round(($data->on_going / $data->module_count) * 100) : 0;
		}

		$data = [
			'progress' => $row_data
		];

		return [
			'additional_information' => $additional_information,
			'column_header' => $column_header,
			'rows' => $data
		];
	}

	/**
	 * @param $student_id
	 * @param $subject_id
	 * @param StudentReportRequest $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getStudentSubjectGradeProgressReport($student_id, $subject_id) {

		//Get student details
		$student = $this->student->getStudent($student_id);

		//Get Avatar thumbnail
		$avatar = $this->avatar->getAvatar($student->avatar_id);
		$avatar_thumbnail = $this->avatar_service->getAvatarThumbnailUrl($avatar->avatar_image);

		//Get subject information
		$subject = $this->subject->getSubject($subject_id);

		//automate class students current class.
		$this->student_service->getCurrentClass($student_id);

		//Get Subject Areas as curriculum.
		$subject_areas = $this->subject_areas->getAreasBySubjectId($subject_id);

		//check valid class subject.
		$class = $this->class_student->getStudentValidClassBySubject($student_id, $subject_id,$student->user->curriculum_country);
		$class_ids = [];

		foreach($class as $classes){
			array_push($class_ids,$classes->class_id);
		}

		//get grades collection
		$grades = $this->grade->getGradesByCountries($student->user->curriculum_country);

		//get student grade
		$student_grade = $this->grade->getGrade($student->grade_code);

		//initiate array.
		$row_data = [];

		//loop to get each data per subject areas.
		foreach ($subject_areas as $areas) {

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

			array_push($row_data, $area);

		}

		//earned_badges
		$badge = $this->student_badges->getStudentBadges([
			'student_id' => $student_id
		]);

		$student_badge = $badge['total'];

		//earned_medals
		$point_level = $this->point_level->findPointsLevel($this->student->getStudentPoints($student_id));
		$student_medal = ($point_level) ? $point_level->id : 0;

		//completed_lessons
		$lessons = $this->class_student->getStudentSubjectProgressByCurriculumCompleted($student_id, $subject_id, $class_ids);

		//written_tips
		$tips = $this->tip->getStudentActiveTips($student_id, $subject_id);

		//week_hours
		$criteria = [
			'date_from' => Carbon::now()->addDay(-7)->toDateTimeString(),
			'date_to' => Carbon::now()->toDateTimeString(),
			'country_id' => $student->user->curriculum_country,
			'student_id' => $student_id,
			'class_id' => $class_ids
		];

		$week = $this->student_module->getStudentSpentHours($criteria);

		$week_hours = (empty($week))? 0 : Carbon::createFromTimestamp($week->total_time)
			->diffInHours(Carbon::createFromTimestamp(0));

		//total_hours
		$criteria['date_from'] = Carbon::createFromTimestamp(0)->toDateTimeString();

		$hours_spent = $this->student_module->getStudentSpentHours($criteria);

		$total_hours = (empty($hours_spent)) ? 0 : Carbon::createFromTimestamp($hours_spent->total_time)
			->diffInHours(Carbon::createFromTimestamp(0));

		$additional_information = [
			'first_name' => $student->first_name,
			'last_name' => $student->last_name,
			'avatar_thumbnail' => $avatar->avatar_image,
			'subject_name' => $subject->name,
			'grade_name' => isset($student_grade->name) ? $student_grade->name : config('futureed.none'),
			'earned_badges' => $student_badge,
			'earned_medals' => $student_medal,
			'completed_lessons' => ($lessons) ? count($lessons->toArray()) : 0,
			'written_tips' => ($tips) ? count($tips->toArray()) : 0,
			'week_hours' => $week_hours,
			'total_hours' => $total_hours,
		];

		$column_header = [['name' => 'Curriculum']];

		$column_header = array_merge($column_header, $grades->toArray());

		$rows = $row_data;

		return [
			'additional_information' => $additional_information,
			'column_header' => $column_header,
			'rows' => $rows
		];
	}

	/**
	 * Get Students current learning.
	 * @param $student_id
	 * @param $subject_id
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getStudentCurrentLearning($student_id, $subject_id) {

		$student_id = ($student_id > 0) ? $student_id : 0;
		$subject_id = ($subject_id > 0) ? $subject_id : 0;

		//automate class students current class.
		$this->student_service->getCurrentClass($student_id);

		//Get student details
		$student = $this->student->getStudent($student_id);

		//Get Avatar thumbnail
		$avatar = $this->avatar->getAvatar($student->avatar_id);

		//Get subject information
		$subject = $this->subject->getSubject($subject_id);

		//check valid class subject.
		$class = $this->class_student->getStudentValidClassBySubject($student_id, $subject_id,$student->user->curriculum_country);

		//get grades collection
		$grades = $this->grade->getGradesByCountries($student->user->curriculum_country);


		$country_id = (empty($this->grade->checkCountry($student->user->curriculum_country)))
			? config('futureed.default_country') : $student->user->curriculum_country;

		//Get student current learning
		$current_learning = $this->class_student->getStudentCurrentLearning($student_id,$subject_id,$country_id);

		$addition_information = [
			'first_name' => $student->first_name,
			'last_name' => $student->last_name,
			'avatar_thumbnail' => $avatar->avatar_image,
			'subject_name' => $subject->name,
		];

		$column_header = [
			'grade_level' => 'Grade Level',
			'curriculum_category' => 'Curriculum Category',
			'percent_completed' => 'Percent Completed',
		];

		$rows = $current_learning;

		return [
			'additional_information' => $addition_information,
			'column_header' => $column_header,
			'rows' => $rows
		];
	}

	/**
	 * Get Student progress heat map data.
	 * @param $student_id
	 * @param $subject_id
	 * @return array
	 */
	public function getSubjectAreaHeatMap($student_id,$subject_id){
		//Get student details
		$student = $this->student->getStudent($student_id);

		//Get Avatar thumbnail
		$avatar = $this->avatar->getAvatar($student->avatar_id);

		//Get subject information
		$subject = $this->subject->getSubject($subject_id);

		//automate class students current class.
		$this->student_service->getCurrentClass($student_id);

		//Get Subject Areas as curriculum.
		$subject_areas = $this->subject_areas->getAreasBySubjectId($subject_id);

		//check valid class subject.
		$class = $this->class_student->getStudentValidClassBySubject($student_id, $subject_id,$student->user->curriculum_country);
		$class_list = $class;
		$class_ids = [];

		foreach($class_list as $classes){
			array_push($class_ids,$classes->class_id);
		}

		//get grades collection
		$grades = $this->grade->getGradesByCountries($student->user->curriculum_country);

		//get student grade
		$student_grade = $this->grade->getGrade($student->grade_code);

		//initiate array.
		$row_data = [];
		$class = $class[0];

		//loop to get each data per subject areas.
		foreach ($subject_areas as $areas) {

			if (!empty($class->toArray())) {

				//get student modules by subject areas
				$curriculum_data = $this->class_student->getStudentSubjectProgressByCurriculum(
					$class->student_id, $areas->id, $class->class_id
				);
			}

			$area = new \stdClass();
			//append to every row of areas
			$curr_data = (!empty($curriculum_data)) ? $curriculum_data : [];

			$area->curriculum_name = $areas->name;

			$area->curriculum_data = $curr_data;

			array_push($row_data, $area);

		}

		//earned_badges
		$badge = $this->student_badges->getStudentBadges([
			'student_id' => $student_id
		]);

		$student_badge = $badge['total'];

		//earned_medals
		$point_level = $this->point_level->findPointsLevel($this->student->getStudentPoints($student_id));
		$student_medal = ($point_level) ? $point_level->id : 0;

		//completed_lessons
		$lessons = $this->class_student->getStudentSubjectProgressByCurriculumCompleted($student_id, $subject_id, $class_ids);

		//written_tips
		$tips = $this->tip->getStudentActiveTips($student_id, $subject_id);

		//week_hours
		$criteria = [
			'date_from' => Carbon::now()->addDay(-7)->toDateTimeString(),
			'date_to' => Carbon::now()->toDateTimeString(),
			'country_id' => $student->user->curriculum_country,
			'student_id' => $student_id,
			'class_id' => $class_ids
		];

		$week = $this->student_module->getStudentSpentHours($criteria);

		$week_hours = (empty($week)) ? 0 : Carbon::createFromTimestamp($week->total_time)
			->diffInHours(Carbon::createFromTimestamp(0));

		//total_hours
		$criteria['date_from'] = Carbon::createFromTimestamp(0)->toDateTimeString();

		$hours_spent = $this->student_module->getStudentSpentHours($criteria);

		$total_hours = (empty($hours_spent)) ? 0 : Carbon::createFromTimestamp($hours_spent->total_time)
			->diffInHours(Carbon::createFromTimestamp(0));

		$additional_information = [
			'first_name' => $student->first_name,
			'last_name' => $student->last_name,
			'avatar_thumbnail' => $avatar->avatar_image,
			'subject_name' => $subject->name,
			'grade_name' => isset($student_grade->name) ? $student_grade->name : config('futureed.none'),
			'earned_badges' => $student_badge,
			'earned_medals' => $student_medal,
			'completed_lessons' => ($lessons) ? count($lessons->toArray()) : 0,
			'written_tips' => ($tips) ? count($tips->toArray()) : 0,
			'week_hours' => $week_hours,
			'total_hours' => $total_hours,
		];

		$column_header = [['name' => 'Curriculum']];

		$column_header = array_merge($column_header, $grades->toArray());

		$rows = $row_data;

		return [
			'additional_information' => $additional_information,
			'column_header' => $column_header,
			'rows' => $rows
		];
	}


	/**
	 * Get student question list report
	 * @param array $criteria
	 */
	public function getStudentQuestionReport($criteria = []){

		//student get country id
		$student = $this->student->getStudent($criteria['student_id']);

		$criteria['country_id'] = $student->user->curriculum_country;

		$this->student_service->getCurrentClass($criteria['student_id']);

		//get current class id
		$current_class = $this->class_student->getStudentCurrentClassCountry(
			$criteria['student_id'],
			$criteria['country_id']
		);

		$class_ids = [];

		foreach($current_class as $class){
			array_push($class_ids,$class->class_id);
		}

		$criteria['class_id'] = $class_ids;


		$question_list = $this->student_module->getStudentQuestionsReport($criteria);

		return $question_list;
	}

	/**
	 * Get student spent hours.
	 * @param $student_id
	 * @return array
	 */
	public function getStudentPlatformHours($student_id){
		//student_id, country_id, class_id,date_from,date_to
		$criteria = [];

		//get student detail for curriculum country
		$student = $this->student->getStudent($student_id);

		$criteria['student_id'] = $student_id;
		$criteria['country_id'] = $student->user->curriculum_country;

		//get current classes -- class_id in array
		$this->student_service->getCurrentClass($student_id);

		$current_class = $this->class_student->getStudentCurrentClassCountry(
			$student_id,
			$criteria['country_id']
		);

		$class_ids = [];

		foreach($current_class as $class){
			array_push($class_ids,$class->class_id);
		}

		$criteria['class_id'] = $class_ids;

		$student_spent_hours = [];


		// Get hours last seven days
		$criteria['date_from'] = Carbon::now()->addDay(-7)->toDateTimeString();
		$criteria['date_to'] = Carbon::now()->toDateTimeString();
		$student_spent_hours['seven_days'] = $this->student_module->getStudentSpentHours($criteria);

		if($student_spent_hours['seven_days']){
			$student_spent_hours['seven_days']->report_name = 'This Week';
			$student_spent_hours['seven_days']->hours_spent = (empty($student_spent_hours['seven_days'])) ?
				0 : Carbon::createFromTimestamp($student_spent_hours['seven_days']->total_time)
				->diffInHours(Carbon::createFromTimestamp(0));
		}

		// Get hours this month
		$criteria['date_from'] = Carbon::now()->startOfMonth()->toDateTimeString();
		$criteria['date_to'] = Carbon::now()->toDateTimeString();
		$student_spent_hours['this_month'] = $this->student_module->getStudentSpentHours($criteria);

		if($student_spent_hours['this_month']){
			$student_spent_hours['this_month']->report_name = 'This Month';
			$student_spent_hours['this_month']->hours_spent = (empty($student_spent_hours['this_month'])) ?
				0 : Carbon::createFromTimestamp($student_spent_hours['this_month']->total_time)
				->diffInHours(Carbon::createFromTimestamp(0));
		}

		// Get hours last month
		$criteria['date_from'] = Carbon::now()->subMonth(1)->startOfMonth()->toDateTimeString();
		$criteria['date_to'] = Carbon::now()->subMonth(1)->lastOfMonth()->toDateTimeString();
		$student_spent_hours['last_month'] = $this->student_module->getStudentSpentHours($criteria);

		if($student_spent_hours['last_month']){
			$student_spent_hours['last_month']->report_name = 'Last Month';
			$student_spent_hours['last_month']->hours_spent = (empty($student_spent_hours['last_month'])) ?
				0 : Carbon::createFromTimestamp($student_spent_hours['last_month']->total_time)
				->diffInHours(Carbon::createFromTimestamp(0));
		}

		return $student_spent_hours;
	}

	/**
	 * Get student platform hours by weekly activities.
	 * @param $student_id
	 * @return array
	 */
	public function getStudentPlatformHoursWeek($student_id){
		//student_id, country_id, class_id,date_from,date_to
		$criteria = [];

		//get student detail for curriculum country
		$student = $this->student->getStudent($student_id);

		$criteria['student_id'] = $student_id;
		$criteria['country_id'] = $student->user->curriculum_country;

		//get current classes -- class_id in array
		$this->student_service->getCurrentClass($student_id);

		$current_class = $this->class_student->getStudentCurrentClassCountry(
			$student_id,
			$criteria['country_id']
		);

		$class_ids = [];

		foreach($current_class as $class){
			array_push($class_ids,$class->class_id);
		}

		$criteria['class_id'] = $class_ids;

		//get hours for the last 7 days

		$student_spent_hours = [];

		//initialize locale for carbon time.
		setlocale(LC_TIME,App::getLocale());

		//loop throughout the days of activities
		for($i=0; $i < config('futureed.last_activity_days'); $i++){

			$criteria['date_from'] =  Carbon::now()->subDay($i+1)->startOfDay()->toDateTimeString();
			$criteria['date_to'] = Carbon::now()->subDay($i)->startOfDay()->toDateTimeString();

			$activity = $this->student_module->getStudentSpentHours($criteria);

			if($activity){
				$activity->hours_spent = (empty($activity)) ? 0 :Carbon::createFromTimestamp($activity->total_time)
					->diffInMinutes(Carbon::createFromTimestamp(0));
			}

			$student_spent_hours[$i] = [
				'week_name' => Carbon::now()->subDay($i)->formatLocalized('%A'),
				'activity' => $activity,
			];
		}

		return $student_spent_hours;
	}

	/**
	 * Get student chart progress completed
	 * @param $student_id
	 * @param $subject_id
	 * @param $grade_id
	 * @return array
	 */
	public function getStudentPlatformSubjectArea($student_id,$subject_id,$grade_id){

		//Get student details
		$student = $this->student->getStudent($student_id);

		//automate class students current class.
		$this->student_service->getCurrentClass($student_id);

		//Get Subject Areas as curriculum.
		$subject_areas = $this->subject_areas->getAreasBySubjectId($subject_id);

		//check valid class subject.
		$class = $this->class_student->getStudentValidClassBySubject($student_id, $subject_id,$student->user->curriculum_country);

		//initiate array.
		$row_data = [];

		//loop to get each data per subject areas.
		foreach ($subject_areas as $areas) {

			if (!empty($class->toArray())) {

				//get student modules by subject areas
				$curriculum_data = $this->class_student->getStudentSubjectProgressByCurriculum(
					$class[0]->student_id, $areas->id, $class[0]->class_id,$grade_id
				);
			}

			$area = new \stdClass();
			//append to every row of areas
			$curr_data = (!empty($curriculum_data)) ? $curriculum_data : [];

			$area->curriculum_name = $areas->name;

			$area->curriculum_data = $curr_data;

			array_push($row_data, $area);

		}

		return $row_data;
	}

	/**
	 * Get student platform chart report heat area.
	 * @param $student_id
	 * @param $subject_id
	 * @param $grade_id
	 * @return array
	 */
	public function getStudentPlatformSubjectAreaHeatMap($student_id,$subject_id,$grade_id){

		//Get student details
		$student = $this->student->getStudent($student_id);

		//automate class students current class.
		$this->student_service->getCurrentClass($student_id);

		//Get Subject Areas as curriculum.
		$subject_areas = $this->subject_areas->getAreasBySubjectId($subject_id);

		//check valid class subject.
		$class = $this->class_student->getStudentValidClassBySubject($student_id, $subject_id,$student->user->curriculum_country);

		//initiate array.
		$row_data = [];

		//loop to get each data per subject areas.
		foreach ($subject_areas as $areas) {

			if (!empty($class->toArray())) {

				//get student modules by subject areas
				$curriculum_data = $this->class_student->getStudentSubjectProgressByCurriculum(
					$class[0]->student_id, $areas->id, $class[0]->class_id,$grade_id
				);
			}

			$area = new \stdClass();
			//append to every row of areas
			$curr_data = (!empty($curriculum_data)) ? $curriculum_data : [];

			$area->curriculum_name = $areas->name;

			$area->curriculum_data = $curr_data;

			array_push($row_data, $area);

		}

		return $row_data;
	}


}
