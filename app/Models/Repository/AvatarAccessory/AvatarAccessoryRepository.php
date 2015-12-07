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