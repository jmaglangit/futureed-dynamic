<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/18/15
 * Time: 4:28 PM
 */

namespace FutureEd\Services;


use FutureEd\Models\Repository\PasswordImage\PasswordImageRepositoryInterface;

class PasswordImageServices {

    public function __construct(PasswordImageRepositoryInterface $password){
        $this->password = $password;
    }

    public function getImages(){

        return $this->password->getImages();

    }

    public function getMixImage($id){

        $dimension = \Config::get('futureed.image_password_count');

        //get images

        $count = ($dimension * $dimension) - 1  ;

        $image_ids = $this->password->getRandomImageId($count, $id);

        return array_merge($image_ids,$this->password->getImage($id)->toArray());

    }

    /*
     * @return returns images for new password set
     */
    public function getNewPasswordImages(){

        $dimension = \Config::get('futureed.image_password_count');

        $dimension *= $dimension;

        $passwordImages = $this->password->getRandomImage($dimension);

        return [
            'status' => 200,
            'data' => $passwordImages
        ];

    }


}