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
        try{
            $result = AvatarWiki::avatarId($avatar_id)->get(['id'])->toArray();
            $avatar_wiki_id = array_rand($result,1);
            return AvatarWiki::find($avatar_wiki_id);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
}