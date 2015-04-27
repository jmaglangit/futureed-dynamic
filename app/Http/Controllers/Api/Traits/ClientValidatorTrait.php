<?php namespace FutureEd\Http\Controllers\Api\Traits;

use FutureEd\Models\Repository\Client\ClientRepositoryInterface;

use Illuminate\Support\Facades\Validator;

trait ClientValidatorTrait {
	
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
    //Validate Email
    public function schoolName($input, $schoolName){

    	if(is_null($input['school_name']) || empty($input['school_name'])){

    		return $this->parameterCheck($input,$schoolName);
    	}
    }
    public function schoolAddress($input, $field_name){

        if(is_null($input['school_address']) || empty($input['school_address'])){

            return $this->parameterCheck($input,$schoolAddress);
        }
        if(!is_null($input["$field_name"]) && !empty($input["$field_name"])){

            $validator = Validator::make(
                [
                    "$field_name" => strtolower($input["$field_name"]),
                ],
                [
                    "$field_name" => 'required|regex:/^[A-Za-z0-9\-\\,.]+$/'
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
    public function schoolState($input, $schoolState){

        if(is_null($input['school_state']) || empty($input['school_state'])){

            return $this->parameterCheck($input,$schoolState);
        }
    }
    public function schoolCountry($input, $schoolCountry){

        if(is_null($input['school_country']) || empty($input['school_country'])){

            return $this->parameterCheck($input,$schoolCountry);
        }
    }
}