<?php namespace FutureEd\Http\Controllers\Api\Traits;

use Illuminate\Support\Facades\Validator;

trait ApiValidatorTrait {

    use ErrorMessageTrait;
    use MessageBagTrait;

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
        $error_msg = config('futureed-error.error_messages');

            $validator = Validator::make(
                [
                    "$birth_date" => $input["$birth_date"],
                ],
                [
                    "$birth_date" => 'required|date_format:Ymd|before:-13 year'
                ],
                [
                    "before" => $error_msg[2028]
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
                    "$first_name" => 'required|min:2|regex:'. config('regex.name') .'|max:64'
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
                    "$last_name" => 'required|min:2|regex:'. config('regex.name') .'|max:64'
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

	public function validateContactName($input,$contact_name){

		$validator = Validator::make(
			[
				"$contact_name" => $input["$contact_name"],
			],
			[
				"$contact_name" => 'required|min:2|regex:'. config('regex.name') .'|max:64'
			]
		);

		if($validator->fails()){

			$validator_msg = $validator->messages()->toArray();

			return $this->setErrorCode(1007)
				->setField($contact_name)
				->setMessage($validator_msg["$contact_name"][0])
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

    //Validate school level field name grade_code
    public function validateGradeCode($input,$field_name){

        $error_msg = config('futureed-error.error_messages');

        $validator = Validator::make(
            [
                "$field_name" => strtolower($input["$field_name"]),
            ],
            [
                "$field_name" => 'required|numeric'
            ],
            [
                "required" => $error_msg[2022],
                "numeric" => $error_msg[2023]
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

    //Validating ang field that is numeric. Can be used by any number field validation.
    public function validateNumber($input,$field_name){

		$error_msg = config('futureed-error.error_messages');

		$validator = Validator::make(
			[
				"$field_name" => strtolower($input["$field_name"]),
			],
			[
				"$field_name" => 'required|numeric'
			],
			[
				"school_code.required" => $error_msg[2602],
				"school_code.numeric" => $error_msg[2602],
				"country_id.required" => $error_msg[2603],
				"country_id.numeric" => $error_msg[2604],
				"school_country_id.required" => $error_msg[2603],
				"school_country_id.numeric" => $error_msg[2604],
				"password_image_id.required" => $error_msg[2138],
			]
		);

		if ($validator->fails()) {

			$validator_msg = $validator->messages()->toArray();

			return $this->setErrorCode(1010)
				->setField($field_name)
				->setMessage($validator_msg["$field_name"][0])
				->errorMessage();
		}
    }

	public function validateNumberOptional($input,$field_name){

		$error_msg = config('futureed-error.error_messages');

		$validator = Validator::make(
			[
				"$field_name" => strtolower($input["$field_name"]),
			],
			[
				"$field_name" => 'numeric'
			],
			[

				"school_code.numeric" => $error_msg[2602],
				"country_id.numeric" => $error_msg[2604],
				"school_country_id.numeric" => $error_msg[2604]
			]
		);

		if ($validator->fails()) {

			$validator_msg = $validator->messages()->toArray();

			return $this->setErrorCode(1010)
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
                    "$field_name" => 'required|string|max:128'
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

                return $this->setErrorCode(1012)
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

                return $this->setErrorCode(1013)
                    ->setField($field_name)
                    ->setMessage($validator_msg["$field_name"][0])
                    ->errorMessage();
            }
    }
    public function clientRole($input,$field_name){

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

                return $this->setErrorCode(1014)
                    ->setField($field_name)
                    ->setMessage($validator_msg["$field_name"][0])
                    ->errorMessage();
            }
    }


    public function checkPassword($input,$field_name){

             $error_msg = config('futureed-error.error_messages');

            $validator = Validator::make(
                [
                    "$field_name" => strtolower($input["$field_name"]),
                ],
                [
                    "$field_name" => 'required|min:8|max:32'
                ]
            );

            $check_password = $this->password->checkPassword($input[$field_name]);

            if($validator->fails()){

                $validator_msg = $validator->messages()->toArray();

                return $this->setErrorCode(1016)
                    ->setField($field_name)
                    ->setMessage($validator_msg["$field_name"][0])
                    ->errorMessage();
            }

            if(!$check_password){

                return $this->setErrorCode(1016)
                    ->setField($field_name)
                    ->setMessage($error_msg[2112])
                    ->errorMessage();
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

            return $this->setErrorCode(1017)
                ->setField("Parameter")
                ->setMessage($validator_msg["$id"][0])
                ->errorMessage();
        }
    }


    public function validateStringOptional($input,$field_name){

            $validator = Validator::make(
                [
                    "$field_name" => strtolower($input["$field_name"]),
                ],
                [
                    "$field_name" => 'string|max:128'
                ]
            );

            if($validator->fails()){

                $validator_msg = $validator->messages()->toArray();

                return $this->setErrorCode(1018)
                    ->setField($field_name)
                    ->setMessage($validator_msg["$field_name"][0])
                    ->errorMessage();
            }
    }
    
    public function zipCodeOptional($input,$field_name){

            $validator = Validator::make(
                [
                    "$field_name" => strtolower($input["$field_name"]),
                ],
                [
                    "$field_name" => 'max:10|regex:'. config('regex.zip_code')
                ],
				[
					'regex' => config('futureed-error.error_messages.2044'),
					'max' => config('futureed-error.error_messages.2045')
				]
            );

            if($validator->fails()){

                $validator_msg = $validator->messages()->toArray();

                return $this->setErrorCode(1019)
                    ->setField($field_name)
                    ->setMessage($validator_msg["$field_name"][0])
                    ->errorMessage();
            }
    }


    public function validatePicturePassword($input,$field_name){

            $error_msg = config('futureed-error.error_messages');
            
            $validator = Validator::make(
                [
                    "$field_name" => strtolower($input["$field_name"]),
                ],
                [
                    "$field_name" => 'required|numeric'
                ],
                [

                    'required' => $error_msg[2017],
                    'numeric' => $error_msg[2101]

                ]
            );

            if($validator->fails()){

                $validator_msg = $validator->messages()->toArray();

                return $this->setErrorCode(1020)
                    ->setField($field_name)
                    ->setMessage($validator_msg["$field_name"][0])
                    ->errorMessage();
            }
    }

    public function emailCode($input,$field_name){
        $error_msg = config('futureed-error.error_messages');

        $validator = Validator::make(
            [
                "$field_name" => strtolower($input["$field_name"]),
            ],
            [
                "$field_name" => 'required|numeric|regex:/^[0-9]{4}(\-[0-9]{4})?$/'
            ],
            [
                'required' => $error_msg[2015],
                'numeric' => $error_msg[2016],
                'regex' => $error_msg[2024]
            ]
        );

        if($validator->fails()){

            $validator_msg = $validator->messages()->toArray();

            return $this->setErrorCode(1021)
                ->setField($field_name)
                ->setMessage($validator_msg["$field_name"][0])
                ->errorMessage();
        }
    }

    public function resetCode($input,$field_name){
        $error_msg = config('futureed-error.error_messages');

        $validator = Validator::make(
            [
                "$field_name" => strtolower($input["$field_name"]),
            ],
            [
                "$field_name" => 'required|numeric|regex:/^[0-9]{4}(\-[0-9]{4})?$/'
            ],
            [
                'required' => $error_msg[2025],
                'numeric' => $error_msg[2026],
                'regex' => $error_msg[2027]
            ]
        );

        if($validator->fails()){

            $validator_msg = $validator->messages()->toArray();

            return $this->setErrorCode(1022)
                ->setField($field_name)
                ->setMessage($validator_msg["$field_name"][0])
                ->errorMessage();
        }
    }


    public function checkContactNumber($input,$field_name){
        $phone_format = "/^((\+|\(|\)|\-)+\s?)?([0-9]+)?((\+|\(|\)|\-)+\s?)?([0-9]+)?((\+|\(|\)|\-)+\s?)?([0-9]+)?((\+|\(|\)|\-)+\s?)?([0-9]+)?$/";

        $validator = Validator::make(
			[
				"$field_name" => strtolower($input["$field_name"]),
			],
			[
				"$field_name" => "required|max:20"
			],
			[
				'max' => config('futureed-error.error_messages.2046')
			]
        );

        if($validator->fails()){

            $validator_msg = $validator->messages()->toArray();

            return $this->setErrorCode(1022)
                ->setField($field_name)
                ->setMessage($validator_msg["$field_name"][0])
                ->errorMessage();
        }

        if(!preg_match($phone_format,$input["$field_name"])){

            return $this->setErrorCode(2115)
                ->setField($field_name)
                ->setMessage(config('futureed-error.error_messages.2115'))
                ->errorMessage();
        }
    }
    
    public function validateDate( $input,$date_field ){
        $error_msg = config('futureed-error.error_messages');
        $validator = Validator::make(
            [
                "$date_field" => $input["$date_field"]
            ],
            [
                "$date_field" => "required|date_format:Ymd"
            ]);
        
        if($validator->fails()){
        
            $validator_msg = $validator->messages()->toArray();
            
            return $this->setErrorCode(1005)
                ->setField($date_field)
                ->setMessage($validator_msg["$date_field"][0])
                ->errorMessage();
        }
    }
    
    public function validateDateRange($input,$date_start,$date_end){
        $error_msg = config('futureed-error.error_messages');
        $validator = Validator::make(
            [
                "$date_start" => $input["$date_start"],
                "$date_end" => $input["$date_end"]
            ],
            [
                "$date_start" => "before:$date_end|after:-1 day"
            ],
            [
                "before" => $error_msg[2500],
                "after" =>$error_msg[2500]
            ]);

        if($validator->fails()){

            $validator_msg = $validator->messages()->toArray();
            
            return $this->setErrorCode(1005)
                ->setField($date_start)
                ->setMessage($validator_msg["$date_start"][0])
                ->errorMessage();
        }
    }

    public function validateStatus($input,$field_name){
        $error_msg = config('futureed-error.error_messages');

        $validator = Validator::make(
            [
                "$field_name" => strtolower($input["$field_name"]),
            ],
            [
                "$field_name" => 'required|in:enabled,disabled'
            ]
        );

        if($validator->fails()){

            $validator_msg = $validator->messages()->toArray();

            return $this->setErrorCode(1022)
                ->setField($field_name)
                ->setMessage($validator_msg["$field_name"][0])
                ->errorMessage();
        }
    }

    public function isAccountReviewed($input,$field_name){

        $error_msg = config('futureed-error.error_messages');

        $validator = Validator::make(
            [
                "$field_name" => strtolower($input["$field_name"]),
            ],
            [
                "$field_name" => 'required|in:1,-1'
            ]
        );

        if($validator->fails()){

            $validator_msg = $validator->messages()->toArray();

            return $this->setErrorCode(1022)
                ->setField($field_name)
                ->setMessage($validator_msg["$field_name"][0])
                ->errorMessage();
        }

    }

     //Validate birth_date field.
    public function editBirthDate($input,$birth_date){
        $error_msg = config('futureed-error.error_messages');

            $validator = Validator::make(
                [
                    "$birth_date" => $input["$birth_date"],
                ],
                [
                    "$birth_date" => 'required|date_format:Ymd|before:-13 year'
                ],
                [
                    "before" => $error_msg[2117]
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

    public function schoolCode($input, $school_code){

        $validator = Validator::make(
            [
                "$school_code" => $input["$school_code"],
            ],
            [
                "$school_code" => 'required|numeric|exists:schools,code,deleted_at,NULL'
            ],
            [
                "exist" => config('futureed-error.error_messages.2602')
            ]
        );

        if($validator->fails()){

            return $this->setErrorCode(2602)
                ->setField($school_code)
                ->setMessage(config('futureed-error.error_messages.2602'))
                ->errorMessage();
        }
    }

    public function validateDateNow($input,$date_now){

        $validator = Validator::make(
            [
                "$date_now" => $input["$date_now"],
            ],
            [
                "$date_now" => 'required|date:today'
            ],
            [
                'date' => config('futureed-error.error_messages.2500')
            ]
        );

        if($validator->fails()){

            $validator_msg = $validator->messages()->toArray();

            return $this->setErrorCode(2500)
                ->setField($date_now)
                ->setMessage($validator_msg["$date_now"][0])
                ->errorMessage();
        }

    }

    // validation for state and city
    // accepts spaces,alphabet characters and dash
    public function validateAlphaSpace($input, $field_name){
        $error_msg = config('futureed-error.error_messages');

            $validator = Validator::make(
                [
                    "$field_name" => strtolower($input["$field_name"]),
                ],
                [
                    "$field_name" => ($field_name == 'state')? 'max:128|regex:/^[-\pL\s]+$/u' : 'required|max:128|regex:/^[-\pL\s]+$/u'
                ]
            );
            if($validator->fails()){

            $validator_msg = $validator->messages()->toArray();

            return $this->setErrorCode(1023)
                ->setField($field_name)
                ->setMessage($validator_msg["$field_name"][0])
                ->errorMessage();
        }
    }

	public function validateAlphaSpaceOptional($input, $field_name){
		$error_msg = config('futureed-error.error_messages');

		$validator = Validator::make(
			[
				"$field_name" => strtolower($input["$field_name"]),
			],
			[
				"$field_name" => ($field_name == 'state')? 'max:128|regex:/^[-\pL\s]+$/u' : 'max:128|regex:/^[-\pL\s]+$/u'
			]
		);
		if($validator->fails()){

			$validator_msg = $validator->messages()->toArray();

			return $this->setErrorCode(1023)
				->setField($field_name)
				->setMessage($validator_msg["$field_name"][0])
				->errorMessage();
		}
	}

	public function validateAlpha($input,$date_now){

		$validator = Validator::make(
			[
				"$date_now" => $input["$date_now"],
			],
			[
				"$date_now" => 'required|alpha'
			]
		);

		if($validator->fails()){

			$validator_msg = $validator->messages()->toArray();

			return $this->setErrorCode(1023)
				->setField($date_now)
				->setMessage($validator_msg["$date_now"][0])
				->errorMessage();
		}

	}

	public function validateAlphaOptional($input,$date_now){

		$validator = Validator::make(
			[
				"$date_now" => $input["$date_now"],
			],
			[
				"$date_now" => 'alpha'
			]
		);

		if($validator->fails()){

			$validator_msg = $validator->messages()->toArray();

			return $this->setErrorCode(1023)
				->setField($date_now)
				->setMessage($validator_msg["$date_now"][0])
				->errorMessage();
		}

	}

}