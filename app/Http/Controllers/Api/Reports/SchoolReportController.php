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

	protected $school;

	protected $student_module;

	protected $school_service;

	public function __construct(
		SchoolRepositoryInterface $schoolRepositoryInterface,
		StudentModuleRepositoryInterface $studentModuleRepositoryInterface,
		SchoolServices $schoolServices
	) {
		$this->school = $schoolRepositoryInterface;
		$this->student_module = $studentModuleRepositoryInterface;
		$this->school_service = $schoolServices;
	}


	public function getSchoolProgress($school_code) {


		// Key Skills to watch
		$skill = $this->school->getSchoolAreaRanking($school_code);

		$skill_watch = [
			'highest_skill' => null,
			'lowest_skill' => null
		];

		if ($skill) {

			$skills = $skill->toArray();
			$skill_watch['highest_skill'] = reset($skills);
			$skill_watch['lowest_skill'] = (count($skills) > 1) ? end($skills) : null;
		}

		// Key classes to watch
		$class = $this->school->getSchoolClassRanking($school_code);

		$class_watch = [
			'highest_class' => null,
			'lowest_class' => null
		];

		if ($class) {

			$classes = $class->toArray();
			$class_watch['highest_class'] = reset($classes);
			$class_watch['lowest_class'] = (count($classes) > 1) ? end($classes) : null;
		}

		// highest scorer - on hold
		// lowest scorer - on hold

		// Key student to watch - refer to previous query
		$student = $this->school->getSchoolStudentRanking($school_code);

		$student_progress = $this->school_service->getStudentProgress($student);

		$student_watch = $student_progress;


		$additional_information = [];

		$column_header = [
			'skills_watch' => 'Key Skill areas to watch',
		];

		$rows = [
			'skills_watch' => $skill_watch,
			'class_watch' => $class_watch,
			'student_watch' => $student_watch
		];

		return $this->respondReportData($additional_information, $column_header, $rows);
	}

	public function getSchoolTeacherProgress($school_code){

		//Teacher progress.
		$class = $this->school->getSchoolClassRanking($school_code);

		$additional_information = [];

		$column_header = [
			'teacher_list' => 'Teacher',
			'progress' => 'Progress'
		];

		$rows = $class->toArray();

		return $this->respondReportData($additional_information, $column_header, $rows);
	}

}
