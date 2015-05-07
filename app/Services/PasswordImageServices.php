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
        $image_folders = \Config::get('futureed.image_password_folder');

        //get images

        $count = ($dimension * $dimension) - 1  ;

        $image_ids = $this->password->getRandomImageId($count, $id);

        $password_image = $this->password->getImage($id)->toArray();

        $password_image[0]['url'] = url() . '/' . $image_folders . '/'
            . $password_image[0]['url'];

        foreach($image_ids as $k => $r){

            $r['url'] = url() . '/' . $image_folders . '/' . $r['url'];
        }

        $merged = array_merge($image_ids, $password_image);

        return $merged;

    }

    /*
     * @return returns images for new password set
     */
    public function getNewPasswordImages(){

        $dimension = \Config::get('futureed.image_password_count');
        $image_folders = \Config::get('futureed.image_password_folder');

        $dimension *= $dimension;

        $password_images = $this->password->getRandomImage($dimension);
        $return_images =array();
        foreach($password_images as $k => $r){

            $r['url'] = url() . '/' . $image_folders . '/' . $r['url'];
            $return_images[]=$r;
        }

        return [
            'status' => 200,
            'data' => $return_images
        ];

    }
    
    
    //returns image_url of current user
    
    public function getUserPasswordImageUrl($image_id){
        
        $image_folders = \Config::get('futureed.image_password_folder');
        
        $password_image= $this->password->getImage($image_id);
        
        $password_image_url = url() . '/' . $image_folders . '/'
            . $password_image[0]['url'];
        
        return $password_image_url;            
    }
    
    public function checkPasswordExist($id){
        
        return $this->password->checkPasswordExist($id);
    }


}