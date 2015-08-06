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
    
    /**
     * Get Avatar poses
     * @param $avatar_id
     * @return Object
     */
    public function getAvatarPoses($avatar_id){
        try {
        
            $results = AvatarPose::avatarId($avatar_id)->get();
            
            return !is_null($results) ? $results->toArray() : null;
        
        } catch(\Exception $e) {
            
            return $e->getMessage();
        
        }
    }
}