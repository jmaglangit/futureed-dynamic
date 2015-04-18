<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/6/15
 * Time: 11:30 AM
 */
namespace FutureEd\Models\Repository\Avatar;

interface AvatarRepositoryInterface {

    public function getAvatars($gender,$count);
    
    public function getAvatar($avatar_id);
   


}