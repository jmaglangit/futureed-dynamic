<?php namespace FutureEd\Http\Controllers\Api\Reports;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Classroom\ClassroomRepositoryInterface;
use FutureEd\Models\Repository\StudentModule\StudentModuleRepository;
use FutureEd\Services\StudentModuleServices;
use Illuminate\Http\Request;

class ClassReportController {


	/**
	 * @var ClassroomRepositoryInterface
	 */
	protected $classroom;

	/**
	 * @var StudentModuleRepository
	 */
	protected $student_module;

	/**
	 * @var StudentModuleServices
	 */
	protected $student_module_service;

	/**
	 * @param ClassroomRepositoryInterface $classroomRepositoryInterface
	 * @param StudentModuleRepository $studentModuleRepository
	 * @param StudentModuleServices $studentModuleServices
	 */
	public function __construct(
		ClassroomRepositoryInterface $classroomRepositoryInterface,
		StudentModuleRepository $studentModuleRepository,
		StudentModuleServices $studentModuleServices
	){
		$this->classroom = $classroomRepositoryInterface;
		$this->student_module = $studentModuleRepository;
		$this->student_module_service = $studentModuleServices;
	}


	/**
	 * @param $class_id
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getClassReport($class_id){


		//get status of the class
		// Grade, teacher information
		$class_data = $this->classroom->getClassroom($class_id);

		// Struggle -- filter by student and status
		$stud_Module = ($this->classroom->checkClassroomActive($class_id))
			? $this->student_module_service->getStudentProgress($class_id)
		: new \stdClass();

		// skills to watch
		// students to watch
		$additional_information = [
			'grade_name' => $class_data->grade->name,
			'subject_name' => $class_data->subject->name,
			'teacher_first_name' => ($class_data->client)? $class_data->client->first_name : null,
			'teacher_last_name' => ($class_data->client)? $class_data->client->last_name : null,
		];

		$column_header = [[
			'student_progress' => [
				'name' => 'Student Name',
				'status' => 'Status'
			],
			'skill_watch' => [
				'stuck' => 'Stuck',
				'high_effort' => 'High Effort'
			],
			'student_watch' => [
				'struggling' => 'Struggling',
				'excelling' => 'Excelling'
			],
		]];

		$rows = [[
			'student_progress' => $stud_Module,
			'skill_watch' => [
				'stuck' => $this->student_module_service->getStuck(),
				'high_effort' => $this->student_module_service->getHighEffort()
			],
			'student_watch' => [
				'struggling' => $this->student_module_service->getStruggling(),
				'excelling' => $this->student_module_service->getExcelling()
			],
		]];

		return [
			'additional_information' => $additional_information,
			'column_header' => $column_header,
			'rows' => $rows
		];
	}

}
