<?php
/**
 * Created by PhpStorm.
 * User: amcuserguy
 * Date: 7/14/15
 * Time: 3:21 PM
 */

namespace FutureEd\Models\Repository\AvatarQuote;


use FutureEd\Models\Core\AvatarQuote;

class AvatarQuoteRepository implements AvatarQuoteRepositoryInterface{

    /**
     * Get Avatar pose id by avatar_id and quote_id
     * @param $avatar_id
     * @param $quote_id
     * @return null|string
     */
    public function getAvatarPoseIdByAvatarIdAndQuoteId($avatar_id,$quote_id){
        try{
            $result = AvatarQuote::avatarId($avatar_id)->quoteId($quote_id)->first();
            return is_null($result) ? null : $result->avatar_pose_id;
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
}