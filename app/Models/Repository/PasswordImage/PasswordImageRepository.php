<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/17/15
 * Time: 10:35 AM
 */

namespace FutureEd\Models\Repository\PasswordImage;

use FutureEd\Models\Core\PasswordImage;
use Illuminate\Support\Facades\Password;


class PasswordImageRepository implements PasswordImageRepositoryInterface{

    public function getImage($id){

        return PasswordImage::select('id','name','password_image_file')
                ->where('id','=',$id)->get();

    }

    public function getImages(){

        return PasswordImage::all();
    }

    public function getRandomImageId($count = 1, $id){

        return PasswordImage::select('id','name','password_image_file')
                ->where('id','<>', $id)->get()->random($count);
    }

    public function getRandomImage($count = 1){

        return PasswordImage::get()->random($count);

    }


}