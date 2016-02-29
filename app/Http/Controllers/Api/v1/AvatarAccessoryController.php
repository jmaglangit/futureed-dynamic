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
		//TODO: Add Pagination.

		$student_id = $request->only('student_id');
		$avatar_accessory = $this->avatar->getAvatarAccessories($student_id);
		if($avatar_accessory){
			return $this->respondWithData($avatar_accessory);
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
		$accessory = $request->all();
		$accessory['user_id'] = $this->student->getUserId($accessory['student_id']);

		//check if user can buy the accessory
		$canBuyAvatarAccessory = $this->avatar_accessory->canBuyAvatarAccessory($accessory['student_id'], $accessory['avatar_accessories_id']);

		if(!$canBuyAvatarAccessory){
			return $this->respondErrorMessage(2067); //This accessory is not available for your avatar
		}

		//check if user already has the accessory
		$hasAvatarAccessory = $this->avatar_accessory->hasAvatarAccessory($accessory);

		if($hasAvatarAccessory){
			return $this->respondErrorMessage(2065); //You already have this accessory
		}

		//check if user still has points to buy
		$total_points = $this->student->getStudentPoints($accessory['student_id']);
		$points_used = $this->student->getStudentPointsUsed($accessory['student_id']);
		$points_left = ($total_points - $points_used) - $accessory['points_to_unlock'];

		if($points_left < 0){
			return $this->respondErrorMessage(2068); //You do not have enough points to buy this accessory
		};

		//update points used on students table here
		$points_used = $points_used + $accessory['points_to_unlock'];
		$this->avatar_accessory->updatePointsUsed($accessory['student_id'], $points_used);

		return $this->respondWithData($this->avatar_accessory->buyAvatarAccessory($accessory));
	}
}