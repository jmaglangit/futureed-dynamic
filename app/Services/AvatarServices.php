<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/6/15
 * Time: 6:01 PM
 */

namespace FutureEd\Services;


use FutureEd\Models\Repository\Avatar\AvatarRepositoryInterface;
use FutureEd\Models\Repository\Validator\ValidatorRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\AvatarAccessory\AvatarAccessoryRepositoryInterface;

class AvatarServices {

    /**
     * Constructors
     * @param AvatarRepositoryInterface $avatar
     * @param ValidatorRepositoryInterface $validator
     * @param StudentRepositoryInterface $student
     * @param AvatarAccessoryRepositoryInterface $avatar_accessory
     */
    public function __construct(AvatarRepositoryInterface $avatar,
        ValidatorRepositoryInterface $validator,
        StudentRepositoryInterface $student,
        AvatarAccessoryRepositoryInterface $avatar_accessory){
        $this->avatar = $avatar;
        $this->validator=$validator;
        $this->student = $student;
        $this->avatar_accessory = $avatar_accessory;
    }

    /**
     * Get Avatars by Gender.
     * @param $gender
     * @return array
     */
    public function getAvatars($gender){
        
        $dimension = \Config::get('futureed.image_avatar_count');
        $image_avatar_folder = \Config::get('futureed.image_avatar_folder');
        
        $image_avatar=$this->avatar->getAvatars($gender,$dimension);
        
        $avatar=array();
        foreach($image_avatar as $k => $r){
            $temp_avatar['id']  = $r['id'];
            $temp_avatar['name']= ucfirst($r['name']);
            $temp_avatar['url'] = url() . '/' . $image_avatar_folder . '/' . $r['avatar_image'];
            $avatar[]= $temp_avatar;
        }
        return $avatar;
    }

    public function genderCheck($input){
        return $this->validator->gender($input);
    }

    /**
     * Get Avatar Id.
     * @param $avatar_id
     * @return mixed
     */
    public function getAvatar($avatar_id){

        return $this->avatar->getAvatar($avatar_id);
    }

    /**
     * Get Avatar image location.
     * @param $avatar_image
     * @return string
     */
    public function getAvatarUrl($avatar_image){
        
        $image_folders = \Config::get('futureed.image_avatar_folder');
        
        
        $password_image_url = url() . '/' . $image_folders . '/'
            . $avatar_image;
        
        return $password_image_url;            
    }

    /**
     * Get Avatar thumbnail url.
     * @param $avatar_image
     * @return string
     */
    public function getAvatarThumbnailUrl($avatar_image){
        
        $thumbnail = \Config::get('futureed.thumbnail');
        
        
        $password_image_url = url() . '/' . $thumbnail . '/'
            . $avatar_image;
        
        return $password_image_url;            
    }

    public function getAvatarBackgroundUrl($avatar_image){

        $image_folder =\Config::get('futureed.image_avatar_folder');

        $background_image = url() . '/' . $image_folder . '/' . $avatar_image;

        return $background_image;
    }
    
    /**
     * Check if Avatar exists.
     * @param $avatar_id
     * @return mixed
     */
    public function checkAvatarExist($avatar_id){
        
        return $this->avatar->checkAvatarExist($avatar_id);
        
    }

    /**
     * Gets avatar accessories.
     * @param $student_id
     * @return array
     */
    public function getAvatarAccessories($student_id) {
        //get the image folder path
        $image_avatar_accessory_folder = config('futureed.image_avatar_accessory_folder');

        //get student's already bought avatar
        $student_avatar_accessories = $this->avatar_accessory->getStudentAvatarAccessories($student_id);
        //dd($student_avatar_accessories);

        //get all avatar accessories based on student id
        $image_avatar=$this->avatar_accessory->getAvatarAccessories($student_id);

        if(!$image_avatar){
            return null;
        }

        foreach($image_avatar as $row){
            $temp_avatar['id'] = $row['id'];
            $temp_avatar['name'] = $row['name'];
            $temp_avatar['url'] = url() . '/' . $image_avatar_accessory_folder . '/' . $row['accessory_image'];
            $temp_avatar['points_to_unlock'] = $row['points_to_unlock'];
            $temp_avatar['description'] = $row['description'];
            $temp_avatar['is_bought'] = in_array($row['id'], array_column($student_avatar_accessories,'avatar_accessories_id'));
            $avatar_accessory[]= $temp_avatar;
        }

        return $avatar_accessory;
    }

}