<?php namespace FutureEd\Http\Controllers\Api\Reports;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Core\ClassStudent;
use FutureEd\Models\Repository\Avatar\AvatarRepositoryInterface;
use FutureEd\Models\Repository\ClassStudent\ClassStudentRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class StudentReportController extends ReportController {

	protected $student;

	protected $avatar;

	protected $class_student;


	/**
	 * StudentReportController constructor.
	 * @param StudentRepositoryInterface $studentRepositoryInterface
	 * @param AvatarRepositoryInterface $avatarRepositoryInterface
	 * @param ClassStudentRepositoryInterface $classStudentRepositoryInterface
	 * @internal param $student
	 */
	public function __construct(
		StudentRepositoryInterface $studentRepositoryInterface,
		AvatarRepositoryInterface $avatarRepositoryInterface,
		ClassStudentRepositoryInterface $classStudentRepositoryInterface
	) {
		$this->student = $studentRepositoryInterface;

		$this->class_student = $classStudentRepositoryInterface;
		$this->avatar = $avatarRepositoryInterface;
	}


	public function getStudentStatusReport($id){

		//TODO: get additional information from student with avatar. get name, grade, avatar

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

		//TODO: get header information based on the report requirements.
		// TODO: get row class_students with classroom, orders, subjects, modules left join student_modules and orders for dates.

		$subject_status = $this->class_student->getClassStudentStanding($id);

//		dd($subject_status->toArray());
		$rows = [$subject_status];


		return $this->respondReportData($additional_information, $column_header, $rows);
	}


}
