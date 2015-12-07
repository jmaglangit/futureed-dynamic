<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests\Api\AvatarAccessoryRequest;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Services\AvatarServices;
use FutureEd\Models\Repository\AvatarAccessory\AvatarAccessoryRepositoryInterface as AvatarAccessory;
use Illuminate\Support\Facades\Input;

class AvatarAccessoryController extends ApiController {

	protected $avatar_accessory;
	protected $avatar;

	public function __construct(AvatarAccessory $avatar_accessory, AvatarServices $avatar){

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


}
