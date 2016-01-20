<?php
/**
 * Created by PhpStorm.
 * User: amcuserguy
 * Date: 7/23/15
 * Time: 2:32 PM
 */

namespace FutureEd\Models\Repository\AvatarWiki;

use FutureEd\Models\Core\AvatarWiki;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class AvatarWikiRepository implements AvatarWikiRepositoryInterface
{

	use LoggerTrait;

	/**
	 * Get a random Avatar Wiki by avatar_id
	 * @param $avatar_id
	 * @return object.
	 */
	public function getAvatarWikiByAvatarId($avatar_id){

		DB::beginTransaction();

		try{
			$wikis = collect(AvatarWiki::select('id')->avatarId($avatar_id)->get()->toArray());

			if (empty($wikis->toArray())) {

				$wikis = collect(AvatarWiki::select('id')->get()->toArray());
			}

			$response = AvatarWiki::find($wikis->random(1));

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}
}