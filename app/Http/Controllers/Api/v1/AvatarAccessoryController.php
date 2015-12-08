<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests\Api\AvatarAccessoryRequest;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Services\AvatarServices;
use FutureEd\Models\Repository\AvatarAccessory\AvatarAccessoryRepositoryInterface as AvatarAccessory;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;

class AvatarAccessoryController extends ApiController {

	protected $avatar_accessory;
	protected $avatar;
	protected $student;

	public function __construct(AvatarAccessory $avatar_accessory
		, AvatarServices $avatar
		, StudentRepositoryInterface $student){

		$this->avatar_accessory = $avatar_accessory;
		$this->avatar = $avatar;
		$this->student = $student;
	}

	/**
	 * Get list of avatar accessoires based on the avatar id of the student
	 * @param $request
	 * @return Object
	 */
	public function getAvatarAccessories(AvatarAccessoryRequest $request)
	{
		$student_id = $request->only('student_id');
		$avatar_accessory = $this->avatar->getAvatarAccessories($student_id);
		if($avatar_accessory){
			return $this->respondWithData();
		}else{
			return $this->respondErrorMessage(2066); //No Accessories available
		}
	}

	/**
	 * Buy an avatar accessory
	 * @param $request
	 * @return Object
	 */
	public function buyAvatarAccessory(AvatarAccessoryRequest $request)
	{
		$data = $request;
		$accessory['user_id'] = intval($data['user_id']);
		$accessory['student_id'] = intval($data['student_id']);
		$accessory['avatar_accessories_id'] = intval($data['accessory_id']);
		$accessory['points_to_unlock'] = intval($data['points_to_unlock']);

		//check if user already has the accessory
		$hasAvatarAccessory = $this->avatar_accessory->hasAvatarAccessory($accessory);

		if($hasAvatarAccessory){
			return $this->respondErrorMessage(2065); //You already have this accessory
		}

		//update points used on students table here
		$points_used = $this->student->getStudentPointsUsed($accessory['student_id']);
		$points_used = $points_used + $accessory['points_to_unlock'];
		$points_to_unlock = $this->avatar_accessory->updatePointsUsed($accessory['student_id'], $points_used);

		$accessory['earned_at'] = Carbon::now();
		$accessory['created_at'] = Carbon::now();
		$accessory['updated_at'] = Carbon::now();

		return $this->respondWithData($this->avatar_accessory->buyAvatarAccessory($accessory));
	}
}