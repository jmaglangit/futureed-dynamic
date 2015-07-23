<?php
/**
 * Created by PhpStorm.
 * User: amcuserguy
 * Date: 7/23/15
 * Time: 2:32 PM
 */

namespace FutureEd\Models\Repository\AvatarWiki;

interface AvatarWikiRepositoryInterface
{
    public function getAvatarWikiByAvatarId($avatar_id);
}