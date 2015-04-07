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

    //implement validation of the username
    public function username($username){
       return true;
    }

    public function firstName($first_name){

    }

    public function lastName($last_name){

    }

    public function gender($gender){

      if(in_array($gender, ['Male','Female'])){

          return true;
      }

    return false;

    }

    public function birthday($birthday){

    }











}