<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/17/15
 * Time: 10:35 AM
 */

namespace FutureEd\Models\Repository\PasswordImage;

use FutureEd\Models\Core\PasswordImage;


class PasswordImageRepository implements PasswordImageRepositoryInterface{

    public function getImage($id){

        return  PasswordImage::select('name','password_image_file as file')
                ->where('id','=',$id)->get();

    }

}