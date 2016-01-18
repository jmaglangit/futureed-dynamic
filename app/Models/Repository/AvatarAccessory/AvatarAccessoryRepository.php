<?php
namespace FutureEd\Models\Repository\AvatarAccessory;

use FutureEd\Models\Core\AvatarAccessory;
use FutureEd\Models\Core\Student;
use FutureEd\Models\Core\StudentAvatarAccessories;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class AvatarAccessoryRepository implements AvatarAccessoryRepositoryInterface{
	
	/**
	 * Get list of avatar accessoires based on the avatar id of the student
	 * @param $student_id
	 * @return Array
	 */
	public function getAvatarAccessories($student_id){

		DB::beginTransaction();

		try {
			$student = new Student();
			$avatar_accessory = new AvatarAccessory();

			$avatar_id = $student->Id($student_id)->pluck('avatar_id');
			$avatar_accessory = $avatar_accessory->AvatarAccessories($avatar_id)->get();
			
			$response = !is_null($avatar_accessory) ? $avatar_accessory->toArray() : null;
		
		} catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get list of all avatar accessories the student has already bought
	 * @param $studnet
	 * @return Array
	 */
	public function getStudentAvatarAccessories($student_id){
		DB::beginTransaction();

		try {
			$student = new Student();
			$student_avatar_accessory = new StudentAvatarAccessories();

			$user_id = $student->Id($student_id)->pluck('user_id');
			$student_avatar_accessory = $student_avatar_accessory->StudentAvatarAccessories($user_id)->get();

			$response = !is_null($student_avatar_accessory) ? $student_avatar_accessory->toArray() : null;

		} catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Check weather or not the accessory the student wants to buy
	 * belongs to the student's current avatar
	 * @param $student_id, $avatar_accessories_id
	 * @return Boolean
	 */
	public function canBuyAvatarAccessory($student_id, $avatar_accessories_id){
		DB::beginTransaction();

		try {
			$student = new Student();
			$avatar_accessory = new AvatarAccessory();

			$avatar_id = $student->Id($student_id)->pluck('avatar_id');
			$avatar_accessory = $avatar_accessory->AvatarAccessories($avatar_id);
			$avatar_accessory = $avatar_accessory->where('id', $avatar_accessories_id)->get()->toArray();

			$response = count($avatar_accessory) >= 1 ? true : false;

		} catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Buy an acessory
	 * @param $accessory
	 * @return Array
	 */
	public function buyAvatarAccessory($accessory){
		try {
			$response = StudentAvatarAccessories::create($accessory)->toArray();

		} catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Check if student has already bought the avatar accessory
	 * @param $accessory
	 * @return Array
	 */
	public function hasAvatarAccessory($accessory){
		try {
			$response = StudentAvatarAccessories::hasAvatarAccessory($accessory)->get()->toArray();

		} catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Updates the ponts used column on the student table
	 * @param $studnet_id
	 * @param $points_used
	 * @return Boolean
	 */
	public function updatePointsUsed($student_id, $points_used){
		try {
			$response = Student::where('id', $student_id)
				->update(['points_used' => $points_used]);
		} catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

}