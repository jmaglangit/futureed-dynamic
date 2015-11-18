<?php namespace FutureEd\Http\Controllers\Api\Reports;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Core\StudentModule;
use FutureEd\Models\Repository\School\SchoolRepositoryInterface;
use FutureEd\Models\Repository\StudentModule\StudentModuleRepositoryInterface;
use FutureEd\Services\SchoolServices;
use FutureEd\Services\StudentModuleServices;
use Illuminate\Http\Request;

class SchoolReportController extends ReportController {

	/**
	 * @var SchoolRepositoryInterface
	 */
	protected $school;

	/**
	 * @var StudentModuleRepositoryInterface
	 */
	protected $student_module;

	/**
	 * @var SchoolServices
	 */
	protected $school_service;

	/**
	 * @param SchoolRepositoryInterface $schoolRepositoryInterface
	 * @param StudentModuleRepositoryInterface $studentModuleRepositoryInterface
	 * @param SchoolServices $schoolServices
	 */
	public function __construct(
		SchoolRepositoryInterface $schoolRepositoryInterface,
		StudentModuleRepositoryInterface $studentModuleRepositoryInterface,
		SchoolServices $schoolServices
	) {
		$this->school = $schoolRepositoryInterface;
		$this->student_module = $studentModuleRepositoryInterface;
		$this->school_service = $schoolServices;
	}


	/**
	 * @param $school_code
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getSchoolProgress($school_code) {


		// Key Skills to watch
		$skill = $this->school->getSchoolAreaRanking($school_code);

		$skill_watch = [
			'highest_skill' => null,
			'lowest_skill' => null
		];

		if ($skill) {

			$skills = $skill->toArray();
			$skill_watch['highest_skill'] = (count($skills) > 0) ? reset($skills): null;
			$skill_watch['lowest_skill'] = (count($skills) > 0) ? end($skills) : null;
		}

		// Key classes to watch
		$class = $this->school->getSchoolClassRanking($school_code);

		$class_watch = [
			'highest_class' => null,
			'lowest_class' => null
		];

		if ($class) {

			$classes = $class->toArray();
			$class_watch['highest_class'] = (count($classes) > 0) ? reset($classes) : null;
			$class_lowest = end($classes);
			$class_watch['lowest_class'] = (count($classes) > 0
					&& $class_watch['highest_class']['class_name'] <> $class_lowest['class_name']) ? $class_lowest : null;
		}




		// Key student to watch - refer to previous query
		$student = $this->school->getSchoolStudentRanking($school_code);

		$student_progress = $this->school_service->getStudentProgress($student);

		$student_watch = $student_progress;

		//Correct Wrong -
		$student_scores = $this->school->getSchoolStudentScores($school_code);


		//Highest score
		$highest_correct_score = $this->school_service->getHighCorrectScores($student_scores);

		//lowest score
		$highest_wrong_score = $this->school_service->getHighWrongScores($student_scores);

		$additional_information = [];

		$column_header = [
			'skills_watch' => 'Key Skill areas to watch',
			'class_watch' => 'Key Classes to watch',
			'student_watch' => 'Key Student to watch',
			'highest_score' => 'Highest Score',
			'lowest_score' => 'Lowest Score'
		];

		$rows = [
			'skills_watch' => $skill_watch,
			'class_watch' => $class_watch,
			'student_watch' => $student_watch,
			'highest_score' => $highest_correct_score,
			'lowest_score' => $highest_wrong_score
		];

		return [
			'additional_information' => $additional_information,
			'column_header' => $column_header,
			'rows' => $rows
		];
	}

	/**
	 * @param $school_code
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getSchoolTeacherProgress($school_code){

		//Teacher progress.
		$class = $this->school->getSchoolClassRanking($school_code);

		$additional_information = [];

		$column_header = [
			'teacher_list' => 'Teacher',
			'progress' => 'Progress'
		];

		$rows = $class->toArray();

		return [
			'additional_information' => $additional_information,
			'column_header' => $column_header,
			'rows' => $rows
		];
	}

}
