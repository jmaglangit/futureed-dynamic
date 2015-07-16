<?php namespace FutureEd\Services;


use Carbon\Carbon;
use FutureEd\Models\Repository\Classroom\ClassroomRepositoryInterface;

class ClassroomServices {

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


		if($classroom->order){

			if($classroom->order->date_start <= Carbon::now()
				&& $classroom->order->date_end >= Carbon::now()){

				return true;

			}

			return false;

		}else{

			return false;
		}



	}

}