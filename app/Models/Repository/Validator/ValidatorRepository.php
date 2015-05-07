<?php namespace FutureEd\Models\Repository\Validator;

use Illuminate\Support\Facades\Validator;


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

        $validator = Validator::make(
            ['value' => $username ],
            ['value' => 'required|min:8|max:32|alpha_num']
        );

        if($validator->fails()){
            return false;
        }

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