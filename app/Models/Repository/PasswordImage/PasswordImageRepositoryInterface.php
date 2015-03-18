<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/17/15
 * Time: 10:35 AM
 */

namespace FutureEd\Models\Repository\PasswordImage;


interface PasswordImageRepositoryInterface {

    /*
     * @param id
     * @return image file
     */
    public function getImage($id);

}