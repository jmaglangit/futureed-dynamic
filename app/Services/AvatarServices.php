<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/6/15
 * Time: 6:01 PM
 */

namespace FutureEd\Services;


use FutureEd\Models\Repository\Avatar\AvatarRepositoryInterface;

class AvatarServices {

    public function __construct(AvatarRepositoryInterface $avatar){
        $this->avatar = $avatar;
    }

    public function getAvatars($gender){
        
        $dimension = \Config::get('futureed.image_avatar_count');
        $image_avatar_folder = \Config::get('futureed.image_avatar_folder');
        
        $image_avatar=$this->avatar->getAvatars($gender,$dimension);
        
        $avatar=array();
        foreach($image_avatar as $k => $r){
            $temp_avatar['avatar_id']=$r['id'];
            $temp_avatar['avatar_url']= url() . '/' . $image_avatar_folder . '/' . $r['avatar_image'];
            $temp_avatar['avatar_name']=$r['avatar_image'];
            $avatar[]= $temp_avatar;
        }
        return $avatar;
    }

   
}