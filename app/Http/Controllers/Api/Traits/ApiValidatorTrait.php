<?php namespace FutureEd\Http\Controllers\Api\Traits;

use FutureEd\Http\Controllers\Api\v1\Traits\ErrorMessageTrait;


trait ApiValidatorTrait {

    use ErrorMessageTrait;

    public $messageBag = [];

    public function setMessageBag($message){
        $this->messageBag = $message;
        return $this;
    }

    public function getMessageBag(){
        return $this->messageBag;
    }

    public function addMessageBag($message){

        if(empty($this->messageBag) && !empty($message)){
            $this->setMessageBag([$message]);
        } elseif(!empty($message) ) {
            $this->messageBag = array_merge(
                $this->getMessageBag(),
                [$message]
            );
        }
    }

    //Check parameters of the fields.
    public function parameterCheck($input, $paramName){

        if(is_null($input["$paramName"])){

            return $this->setErrorCode(1001)
                ->setField($paramName)
                ->setMessage("Required field not found.")
                ->errorMessage();


        } elseif(empty($input["$paramName"])){

            return  $this->setErrorCode(1002)
                ->setField($paramName)
                ->setMessage("Empty required field.")
                ->errorMessage();
        }

    }

    //Check email validations.
    public function email($input, $email){

        if(is_null($input["$email"]) || empty($input["$email"])){

            return $this->parameterCheck($input,$email);
        }

        if(!is_null($input["$email"]) && !empty($input["$email"])){

            $validator = Validator::make(
                [
                    "$email" => $input["$email"],
                ],
                [
                    "$email" => 'required|email'
                ]
            );

            if($validator->fails()){

                $validator_msg = $validator->messages()->toArray();

                return $this->setErrorCode(1003)
                    ->setField($email)
                    ->setMessage($validator_msg["$email"][0])
                    ->errorMessage();

            }
        }
    }

    //Validate username field.
    public function username($input,$username){

        if(is_null($input["$username"]) || empty($input["$username"])){

            return $this->parameterCheck($input,$username);
        }

        if(!is_null($input["$username"]) && !empty($input["$username"])){

            $validator = Validator::make(
                [
                    "$username" => $input["$username"],
                ],
                [
                    "$username" => 'required|min:8|max:32|alpha_num'
                ]
            );

            if($validator->fails()){

                $validator_msg = $validator->messages()->toArray();

                return $this->setErrorCode(1004)
                    ->setField($username)
                    ->setMessage($validator_msg["$username"][0])
                    ->errorMessage();
            }
        }
    }


    //Validate birth_date field.
    public function birthDate($input,$birth_date){

        if(is_null($input["$birth_date"]) || empty($input["$birth_date"])){

            return $this->parameterCheck($input,$birth_date);
        }

        if(!is_null($input["$birth_date"]) && !empty($input["$birth_date"])){

            $validator = Validator::make(
                [
                    "$birth_date" => $input["$birth_date"],
                ],
                [
                    "$birth_date" => 'required|date_format:Ymd|before:today'
                ]
            );

            if($validator->fails()){

                $validator_msg = $validator->messages()->toArray();

                return $this->setErrorCode(1005)
                    ->setField($birth_date)
                    ->setMessage($validator_msg["$birth_date"][0])
                    ->errorMessage();
            }
        }

    }

    //Validate first_name with multiple names
    public function firstName($input,$first_name){

        if(is_null($input["$first_name"]) || empty($input["$first_name"])){

            return $this->parameterCheck($input,$first_name);
        }

        if(!is_null($input["$first_name"]) && !empty($input["$first_name"])){

            $validator = Validator::make(
                [
                    "$first_name" => $input["$first_name"],
                ],
                [
                    "$first_name" => 'required|regex:/^([a-z\x20])+$/i'
                ]
            );

            if($validator->fails()){

                $validator_msg = $validator->messages()->toArray();

                return $this->setErrorCode(1006)
                    ->setField($first_name)
                    ->setMessage($validator_msg["$first_name"][0])
                    ->errorMessage();
            }
        }
    }

    //Validate last_name field
    public function lastName($input,$last_name){

        if(is_null($input["$last_name"]) || empty($input["$last_name"])){

            return $this->parameterCheck($input,$last_name);
        }

        if(!is_null($input["$last_name"]) && !empty($input["$last_name"])){

            $validator = Validator::make(
                [
                    "$last_name" => $input["$last_name"],
                ],
                [
                    "$last_name" => 'required|alpha_num'
                ]
            );

            if($validator->fails()){

                $validator_msg = $validator->messages()->toArray();

                return $this->setErrorCode(1007)
                    ->setField($last_name)
                    ->setMessage($validator_msg["$last_name"][0])
                    ->errorMessage();
            }
        }
    }

    //Validate gender -- accepts any type of case
    public function gender($input,$gender){


        if(is_null($input["$gender"]) || empty($input["$gender"])){

            return $this->parameterCheck($input,$gender);
        }

        if(!is_null($input["$gender"]) && !empty($input["$gender"])){

            $validator = Validator::make(
                [
                    "$gender" => strtolower($input["$gender"]),
                ],
                [
                    "$gender" => 'required|alpha|in:male,female'
                ]
            );

            if($validator->fails()){

                $validator_msg = $validator->messages()->toArray();

                return $this->setErrorCode(1007)
                    ->setField($gender)
                    ->setMessage($validator_msg["$gender"][0])
                    ->errorMessage();
            }
        }
    }

    //Validating ang field that is numeric. Can be used by any number field validation.
    public function validateNumber($input,$field_name){

        if(is_null($input["$field_name"]) || empty($input["$field_name"])){

            return $this->parameterCheck($input,$field_name);
        }

        if(!is_null($input["$field_name"]) && !empty($input["$field_name"])){

            $validator = Validator::make(
                [
                    "$field_name" => strtolower($input["$field_name"]),
                ],
                [
                    "$field_name" => 'required|numeric'
                ]
            );

            if($validator->fails()){

                $validator_msg = $validator->messages()->toArray();

                return $this->setErrorCode(1009)
                    ->setField($field_name)
                    ->setMessage($validator_msg["$field_name"][0])
                    ->errorMessage();
            }
        }

    }

    public function validateString($input,$field_name){

        if(is_null($input["$field_name"]) || empty($input["$field_name"])){

            return $this->parameterCheck($input,$field_name);
        }

        if(!is_null($input["$field_name"]) && !empty($input["$field_name"])){

            $validator = Validator::make(
                [
                    "$field_name" => strtolower($input["$field_name"]),
                ],
                [
                    "$field_name" => 'required|string'
                ]
            );

            if($validator->fails()){

                $validator_msg = $validator->messages()->toArray();

                return $this->setErrorCode(1010)
                    ->setField($field_name)
                    ->setMessage($validator_msg["$field_name"][0])
                    ->errorMessage();
            }
        }
    }



}