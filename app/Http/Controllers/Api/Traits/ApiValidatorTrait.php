<?php namespace FutureEd\Http\Controllers\Api\Traits;

use Illuminate\Support\Facades\Validator;

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
        $error_msg = config('futureed-error.error_messages');

        if(is_null($input["$paramName"])){

            return $this->setErrorCode(1001)
                ->setField($paramName)
                ->setMessage($error_msg[1001])
                ->errorMessage();


        } elseif(empty($input["$paramName"])){

            return  $this->setErrorCode(1002)
                ->setField($paramName)
                ->setMessage($error_msg[1002])
                ->errorMessage();
        }

    }

    //Check email validations.
    public function email($input, $email){

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

    //Validate username field.
    public function username($input,$username){

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


    //Validate birth_date field.
    public function birthDate($input,$birth_date){

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

    //Validate first_name with multiple names
    public function firstName($input,$first_name){

            $validator = Validator::make(
                [
                    "$first_name" => $input["$first_name"],
                ],
                [
                    "$first_name" => 'required|regex:/^([a-z\x20])+$/i|max:64'
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

    //Validate last_name field
    public function lastName($input,$last_name){

            $validator = Validator::make(
                [
                    "$last_name" => $input["$last_name"],
                ],
                [
                    "$last_name" => 'required|regex:/^([a-z\x20])+$/i|max:64'
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

    //Validate gender -- accepts any type of case
    public function gender($input,$gender){

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

                return $this->setErrorCode(1008)
                    ->setField($gender)
                    ->setMessage($validator_msg["$gender"][0])
                    ->errorMessage();
            }
    }

    //Validating ang field that is numeric. Can be used by any number field validation.
    public function validateNumber($input,$field_name){


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

    public function validateString($input,$field_name){

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
    
    public function emptyUsername($input,$field_name){
        
          if(is_null($input["$field_name"]) || empty($input["$field_name"])){

            return $this->parameterCheck($input,$field_name);
          }
    }
    
    public function userType($input,$field_name){


            $validator = Validator::make(
                [
                    "$field_name" => strtolower($input["$field_name"]),
                ],
                [
                    "$field_name" => 'required|in:admin,client,student'
                ]
            );

            if($validator->fails()){

                $validator_msg = $validator->messages()->toArray();

                return $this->setErrorCode(1011)
                    ->setField($field_name)
                    ->setMessage($validator_msg["$field_name"][0])
                    ->errorMessage();
            }
    }


    public function userTypeClientStudent($input,$field_name){

            $validator = Validator::make(
                [
                    "$field_name" => strtolower($input["$field_name"]),
                ],
                [
                    "$field_name" => 'required|in:client,student'
                ]
            );

            if($validator->fails()){

                $validator_msg = $validator->messages()->toArray();

                return $this->setErrorCode(1011)
                    ->setField($field_name)
                    ->setMessage($validator_msg["$field_name"][0])
                    ->errorMessage();
            }
    }
    public function clientRole($input,$field_name){

        if(is_null($input["$field_name"]) || empty($input["$field_name"])){

            return $this->parameterCheck($input,$field_name);
        }

        if(!is_null($input["$field_name"]) && !empty($input["$field_name"])){

            $validator = Validator::make(
                [
                    "$field_name" => strtolower($input["$field_name"]),
                ],
                [
                    "$field_name" => 'required|in:parent,principal,teacher'
                ]
            );

            if($validator->fails()){

                $validator_msg = $validator->messages()->toArray();

                return $this->setErrorCode(1012)
                    ->setField($field_name)
                    ->setMessage($validator_msg["$field_name"][0])
                    ->errorMessage();
            }
        }
    }

    public function zipCode($input,$field_name){

        if(is_null($input["$field_name"]) || empty($input["$field_name"])){

            return $this->parameterCheck($input,$field_name);
        }

        if(!is_null($input["$field_name"]) && !empty($input["$field_name"])){

            $validator = Validator::make(
                [
                    "$field_name" => strtolower($input["$field_name"]),
                ],
                [
                    "$field_name" => 'required|digits:5|integer'
                ]
            );

            if($validator->fails()){

                $validator_msg = $validator->messages()->toArray();

                return $this->setErrorCode(1013)
                    ->setField($field_name)
                    ->setMessage($validator_msg["$field_name"][0])
                    ->errorMessage();
            }
        }
    }
    public function checkPassword($input,$field_name){

        if(is_null($input["$field_name"]) || empty($input["$field_name"])){

            return $this->parameterCheck($input,$field_name);
        }

        if(!is_null($input["$field_name"]) && !empty($input["$field_name"])){

            $validator = Validator::make(
                [
                    "$field_name" => strtolower($input["$field_name"]),
                ],
                [
                    "$field_name" => 'required|min:8|max:32'
                ]
            );

            if($validator->fails()){

                $validator_msg = $validator->messages()->toArray();

                return $this->setErrorCode(2230)
                    ->setField($field_name)
                    ->setMessage($validator_msg["$field_name"][0])
                    ->errorMessage();
            }
        }
    }

    public function validateVarNumber($id){

        $validator = Validator::make(
            [
                "$id" => $id
            ],
            [
                "$id" => 'required|numeric'
            ]
        );

        if($validator->fails()){

            $validator_msg = $validator->messages()->toArray();

            return $this->setErrorCode(1011)
                ->setField("Parameter")
                ->setMessage($validator_msg["$id"][0])
                ->errorMessage();
        }
    }
}