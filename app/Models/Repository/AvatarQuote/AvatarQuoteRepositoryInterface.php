<?php
/**
 * Created by PhpStorm.
 * User: amcuserguy
 * Date: 7/14/15
 * Time: 3:21 PM
 */

namespace FutureEd\Models\Repository\AvatarQuote;


interface AvatarQuoteRepositoryInterface {
    public function getAvatarPoseIdByAvatarIdAndQuoteId($avatar_id,$quote_id);
}