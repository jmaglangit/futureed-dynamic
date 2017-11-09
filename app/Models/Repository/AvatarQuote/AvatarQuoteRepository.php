<?php
/**
 * Created by PhpStorm.
 * User: amcuserguy
 * Date: 7/14/15
 * Time: 3:21 PM
 */

namespace FutureEd\Models\Repository\AvatarQuote;


use FutureEd\Models\Core\AvatarQuote;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class AvatarQuoteRepository implements AvatarQuoteRepositoryInterface{

	use LoggerTrait;

	/**
	 * Get Avatar pose id by avatar_id and quote_id
	 * @param $avatar_id
	 * @param $quote_id
	 * @return null|string
	 */
	public function getAvatarPoseIdByAvatarIdAndQuoteId($avatar_id,$quote_id){

		DB::beginTransaction();

		try{
			$result = AvatarQuote::avatarId($avatar_id)->quoteId($quote_id)->first();
			$response = is_null($result) ? null : $result->avatar_pose_id;

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}
}