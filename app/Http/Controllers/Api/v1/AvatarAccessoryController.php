<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests\Api\AvatarAccessoryRequest;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Models\Repository\AvatarAccessory\AvatarAccessoryRepositoryInterface as AvatarAccessory;
use Illuminate\Support\Facades\Input;

class AvatarAccessoryController extends ApiController {

	protected $avatar_accessory;

	public function __construct(AvatarAccessory $avatar_accessory){

		$this->avatar_accessory = $avatar_accessory;
	}

	/**
	 * Get list of avatar accessoires based on the avatar id of the student
	 * @param $request
	 * @return Object
	 */
	public function getAvatarAccessories(AvatarAccessoryRequest $request)
	{
		$student_id = $request->only('student_id');
		
		return $this->respondWithData($this->avatar_accessory->getAvatarAccessories($student_id));
	}


}
