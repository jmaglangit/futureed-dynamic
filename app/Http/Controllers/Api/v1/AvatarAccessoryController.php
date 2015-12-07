<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests\Api\AvatarAccessoryRequest;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Services\AvatarServices;
use FutureEd\Models\Repository\AvatarAccessory\AvatarAccessoryRepositoryInterface as AvatarAccessory;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;

class AvatarAccessoryController extends ApiController {

	protected $avatar_accessory;
	protected $avatar;
	protected $student_avatar_accessory;

	public function __construct(AvatarAccessory $avatar_accessory
		, AvatarServices $avatar){

		$this->avatar_accessory = $avatar_accessory;
		$this->avatar = $avatar;
	}

	/**
	 * Get list of avatar accessoires based on the avatar id of the student
	 * @param $request
	 * @return Object
	 */
	public function getAvatarAccessories(AvatarAccessoryRequest $request)
	{
		$student_id = $request->only('student_id');
		return $this->respondWithData($this->avatar->getAvatarAccessories($student_id));
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
		$accessory['avatar_accessories_id'] = intval($data['accessory_id']);

		//check if user already has the accessory
		$hasAvatarAccessory = $this->avatar_accessory->hasAvatarAccessory($accessory);

		if(!$hasAvatarAccessory){
			//update points used on students table here

			$accessory['earned_at'] = Carbon::now();
			$accessory['created_at'] = Carbon::now();
			$accessory['updated_at'] = Carbon::now();

			return $this->avatar_accessory->buyAvatarAccessory($accessory);
		}else{
			return $this->respondErrorMessage(2065); //You already have this accessory
		}
	}
}