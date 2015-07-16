<?php namespace FutureEd\Services;


use FutureEd\Models\Repository\Classroom\ClassroomRepositoryInterface;

class Classroom {

	/**
	 * @var ClassroomRepositoryInterface
	 */
	protected $classroom;

	/**
	 * @param ClassroomRepositoryInterface $classroomRepositoryInterface
	 */
	public function __construct(
		ClassroomRepositoryInterface $classroomRepositoryInterface
	){
		$this->classroom = $classroomRepositoryInterface;
	}


	/**
	 * Check classroom.
	 * @param $class_id
	 */
	public function checkActiveClassroom($class_id){

		$classroom = $this->classroom->getClassroom($class_id);

		dd($classroom->toArray());



	}

}