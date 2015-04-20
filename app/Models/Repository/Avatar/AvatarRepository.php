<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/6/15
 * Time: 11:30 AM
 */
namespace FutureEd\Models\Repository\Avatar;

use FutureEd\Models\Core\Avatar;
use FutureEd\Models\Core\User;
use League\Flysystem\Exception;

class AvatarRepository implements AvatarRepositoryInterface{

    public function getAvatars($gender,$count){
    	return Avatar::where('gender','=', $gender)->get()->random($count);
    }
    
    public function getAvatar($avatar_id){
    	return Avatar::where('id','=',$avatar_id)->get()->first();
    }
    
    public function checkAvatarExist($avatar_id){
    	
    	return Avatar::where('id','=',$avatar_id)->pluck('id');
    	
    }

}