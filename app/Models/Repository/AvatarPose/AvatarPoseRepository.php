<?php
namespace FutureEd\Models\Repository\AvatarPose;

use FutureEd\Models\Core\AvatarPose;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class AvatarPoseRepository implements AvatarPoseRepositoryInterface{

	use LoggerTrait;

	/**
	 * Get Avatar pose
	 * @param $id
	 * @return Object
	 */
	public function getAvatarPose($id){

		DB::beginTransaction();

		try{
			$response = AvatarPose::find($id);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get Avatar poses
	 * @param $avatar_id
	 * @return Object
	 */
	public function getAvatarPoses($avatar_id){

		DB::beginTransaction();

		try {

			$results = AvatarPose::avatarId($avatar_id)->get();

			$response = !is_null($results) ? $results->toArray() : null;

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}
}