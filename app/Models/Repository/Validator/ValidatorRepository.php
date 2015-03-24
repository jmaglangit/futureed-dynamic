<?php namespace FutureEd\Models\Repository\Validator;
use Illuminate\Support\Facades\Validator;

/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/11/15
 * Time: 2:38 PM
 */




class ValidatorRepository implements ValidatorRepositoryInterface{

    //email validations
    public function email($email){
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            return false;
        } else {
            return true;
        }
    }

    public function username($username){
       return 1;
    }

    public function firstName($firstName){

    }

    public function lastName($lastName){

    }

    public function gender($gender){

    }

    public function birthday($birthday){

    }











}