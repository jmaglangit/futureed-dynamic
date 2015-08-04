<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\AvatarPose\AvatarPoseRepositoryInterface as AvatarPose;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;

class AvatarPoseController extends ApiController {

	protected $avatar_pose;

	public function __construct(AvatarPose $avatar_pose){

		$this->avatar_pose = $avatar_pose;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$avatar_id = null;
	
		//for avatar_id
		if(Input::get('avatar_id')){

			$avatar_id = Input::get('avatar_id');
		}
	
		
		if($avatar_id) {
			return $this->respondWithData($this->avatar_pose->getAvatarPoses($avatar_id));
		} else {
			return $this->respondWithData(null);
		}
		
		
	}


}
