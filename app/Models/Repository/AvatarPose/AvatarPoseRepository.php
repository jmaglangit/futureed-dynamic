<?php
namespace FutureEd\Models\Repository\AvatarPose;

use FutureEd\Models\Core\AvatarPose;

class AvatarPoseRepository implements AvatarPoseRepositoryInterface{

    /**
     * Get Avatar pose
     * @param $id
     * @return Object
     */
    public function getAvatarPose($id){
        try{
            return AvatarPose::find($id);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
}