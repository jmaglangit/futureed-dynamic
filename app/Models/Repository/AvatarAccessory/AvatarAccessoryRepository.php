<?php
namespace FutureEd\Models\Repository\AvatarAccessory;

use FutureEd\Models\Core\AvatarAccessory;
use FutureEd\Models\Core\Student;
use FutureEd\Models\Core\StudentAvatarAccessories;
use Illuminate\Support\Facades\Session;

class AvatarAccessoryRepository implements AvatarAccessoryRepositoryInterface{
	
	/**
	 * Get list of avatar accessoires based on the avatar id of the student
	 * @param $student_id
	 * @return Object
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

		dd('test student avatar accessory');
	}

	public function buyAvatarAccessory($accessory){
		try {
			return StudentAvatarAccessories::create($accessory)->toArray();
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	public function hasAvatarAccessory($accessory){
		try {
			return StudentAvatarAccessories::hasAvatarAccessory($accessory)->get()->toArray();
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}
}