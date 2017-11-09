<?php namespace FutureEd\Models\Repository\Validator;
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/11/15
 * Time: 2:37 PM
 */

interface ValidatorRepositoryInterface {

    public function email($email);

    public function username($username);

    public function gender($gender);

}