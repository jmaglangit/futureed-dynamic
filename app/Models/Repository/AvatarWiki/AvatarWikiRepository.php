<?php
/**
 * Created by PhpStorm.
 * User: amcuserguy
 * Date: 7/23/15
 * Time: 2:32 PM
 */

namespace FutureEd\Models\Repository\AvatarWiki;

use FutureEd\Models\Core\AvatarWiki;

class AvatarWikiRepository implements AvatarWikiRepositoryInterface
{
    /**
     * Get a random Avatar Wiki by avatar_id
     * @param $avatar_id
     * @return object.
     */
    public function getAvatarWikiByAvatarId($avatar_id){


        $wikis = collect(AvatarWiki::select('id')->avatarId($avatar_id)->get()->toArray());

        if(empty($wikis->toArray())){

            $wikis = collect(AvatarWiki::select('id')->get()->toArray());
        }

		return AvatarWiki::find($wikis->random(1));

    }
}