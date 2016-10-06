<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 5/26/15
 * Time: 3:36 PM
 */

namespace FutureEd\Models\Repository\Classroom;


use FutureEd\Models\Core\Classroom;
use FutureEd\Models\Core\ClassStudent;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;

class ClassroomRepository implements ClassroomRepositoryInterface{


	use LoggerTrait;

	/**
	 * Get list of classroom based with optional pagination.
	 * @param $criteria
	 * @param $limit
	 * @param $offset
	 * @return array
	 */
	public function getClassrooms($criteria,$limit,$offset){

		DB::beginTransaction();

		try{

			$classroom = new Classroom();

			//get client id -- teacher
			if (isset($criteria['client_id'])) {

				$classroom = $classroom->client_id($criteria['client_id']);
			}

			if (isset($criteria['name'])) {

				$classroom = $classroom->name($criteria['name']);
			}

			if (isset($criteria['grade_id'])) {

				$classroom = $classroom->grade_id($criteria['grade_id']);
			}

			if (isset($criteria['order_no'])) {

				$classroom = $classroom->order_no($criteria['order_no']);
			}

			if (isset($criteria['payment_status'])) {

				$classroom = $classroom->paymentStatus($criteria['payment_status']);
			}

			$classroom = $classroom->with('order', 'grade', 'client','subject');

			$count = $classroom->get()->count();

			if ($offset >= 0 && $limit > 0) {

				$classroom = $classroom->skip($offset)->take($limit);
			}

			$records = $classroom->get();

			$response = [
				'total' => $count,
				'record' => $records
			];

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get classroom information.
	 * @param $id
	 * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection|null|static
	 */
	public function getClassroom($id){

		DB::beginTransaction();

		try{
			$response = Classroom::with('order','grade','client','subject','invoice')->find($id);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Add new classroom.
	 * @param $classroom
	 * @return string|static
	 */
	public function addClassroom($classroom){

		DB::beginTransaction();

		try{

			$response = Classroom::create($classroom);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}


	/**
	 * Update new classroom based on the data needed.
	 * @param $id
	 * @param $data
	 * @return ClassroomRepository|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection|null|string|static
	 */
	public function updateClassroom($id,$data){

		DB::beginTransaction();

		try{

			Classroom::find($id)->update($data);

			$response = $this->getClassroom($id);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;

	}

	/**
	 * Delete Classroom
	 * @param $id
	 */
	public function deleteClassroom($id){

		DB::beginTransaction();

		try{

			$response = Classroom::find($id)->delete();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 *  Delete classrooms by order no.
	 *  @param $order_no
	 *  @return boolean
	 */

	public function deleteClassroomByOrderNo($order_no){

		DB::beginTransaction();

		try{

			$response = Classroom::order_no($order_no)->delete();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Update Classroom by Order No.
	 * @param $order_no
	 * @param $data
	 * @return string
	 */
	public function updateClassroomByOrderNo($order_no, $data){

		DB::beginTransaction();
		try{

		   $response = Classroom::whereOrderNo($order_no)->update($data);

		} catch(\Exception $e){

			DB::rollback();

			$this->errorLog($e->get());

			return $e->getMessage();
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $order_no
	 * @return null|string
	 */
	public function getClassroomByOrderNo($order_no){

		DB::beginTransaction();

		try{
			$result = Classroom::order_no($order_no);
			$result = $result->with('client')->get();
			$response = !is_null($result) ? $result->toArray():null;

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 *  Get classroom by subject and by student.
	 *  @param $subject_id
	 *  @param $student_id
	 *  @return boolean
	 */

	public function getClassroomBySubjectId($subject_id,$student_id){

		DB::beginTransaction();

		try{
			$classroom = new Classroom();

			$classroom = $classroom->subject_Id($subject_id);
			$classroom = $classroom->active();
			$classroom = $classroom->student_id($student_id);
			$classroom = $classroom->with('classStudent')->get();

			$response = !is_null($classroom) ? $classroom->toArray():null;

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 *  Gets active subscription of a student based on a subject id
	 *  @param $subject_id
	 *  @param $student_id
	 *  @return boolean
	 */
	public function getActiveSubscription($subject_id, $student_id,$country){

		DB::beginTransaction();

		try{
			$class_student = new  ClassStudent();

			$class_student = $class_student->with('student','classroom');
			$class_student = $class_student->subscriptionSubjectId($subject_id);
			$class_student = $class_student->subscriptionStudentId($student_id);
			$class_student = $class_student->subscriptionStatus();
			$class_student = $class_student->subscriptionCountry($country);

			$response = count($class_student->get()->toArray());

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}


	/**
	 * @param $class_id
	 * @return string
	 */
	public function checkClassroomActive($class_id){


		DB::beginTransaction();
		try{

			$response = Classroom::with('order')
				->paymentStatus(config('futureed.paid'))
				->validSubscription()
				->find($class_id);
				
		} catch(\Exception $e){

			DB::rollback();

			$this->errorLog($e->get());

			return $e->getMessage();
		}

		DB::commit();

		return $response;
	}

}