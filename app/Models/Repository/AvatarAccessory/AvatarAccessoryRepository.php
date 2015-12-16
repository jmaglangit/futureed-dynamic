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
		$student = new Student();
		$avatar_accessory = new AvatarAccessory();

		try {
			$avatar_id = $student->Id($student_id)->pluck('avatar_id');
			$avatar_accessory = $avatar_accessory->AvatarAccessories($avatar_id)->get();
			
			return !is_null($avatar_accessory) ? $avatar_accessory->toArray() : null;
		
		} catch(\Exception $e) {
			
			return $e->getMessage();
		
		}
	}

	/**
	 * Get list of all avatar accessories the student has already bought
	 * @param $studnet
	 * @return Array
	 */
	public function getStudentAvatarAccessories($student_id){
		$student = new Student();
		$student_avatar_accessory = new StudentAvatarAccessories();

		try {
			$user_id = $student->Id($student_id)->pluck('user_id');
			$student_avatar_accessory = $student_avatar_accessory->StudentAvatarAccessories($user_id)->get();

			return !is_null($student_avatar_accessory) ? $student_avatar_accessory->toArray() : null;

		} catch(\Exception $e) {

			return $e->getMessage();

		}
	}

	/**
	 * Return true or false weather the student can buy the accessory
	 * @param $student_id, $avatar_accessories_id
	 * @return Boolean
	 */
	public function canBuyAvatarAccessory($student_id, $avatar_accessories_id){
		$student = new Student();
		$avatar_accessory = new AvatarAccessory();

		try {
			$avatar_id = $student->Id($student_id)->pluck('avatar_id');
			$avatar_accessory = $avatar_accessory->AvatarAccessories($avatar_id);
			$avatar_accessory = $avatar_accessory->where('id', $avatar_accessories_id)->get()->toArray();
			return count($avatar_accessory) >= 1 ? true : false;

		} catch(\Exception $e) {
			return $e->getMessage();

		}
	}

	/**
	 * Buy an acessory
	 * @param $accessory
	 * @return Array
	 */
	public function buyAvatarAccessory($accessory){
		try {
			return StudentAvatarAccessories::create($accessory)->toArray();
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	/**
	 * Check if student has already bought the avatar accessory
	 * @param $accessory
	 * @return Array
	 */
	public function hasAvatarAccessory($accessory){
		try {
			return StudentAvatarAccessories::hasAvatarAccessory($accessory)->get()->toArray();
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	/**
	 * Updates the ponts used column on the student table
	 * @param $studnet_id
	 * @param $points_used
	 * @return Boolean
	 */
	public function updatePointsUsed($student_id, $points_used){
		try {
			return Student::where('id', $student_id)
				->update(['points_used' => $points_used]);
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

}