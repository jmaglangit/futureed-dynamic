<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Validator\ValidatorRepositoryInterface;
use FutureEd\Services\ClientServices;
use FutureEd\Services\CodeGeneratorServices;
use FutureEd\Services\GradeServices;
use FutureEd\Services\MailServices;
use FutureEd\Services\PasswordImageServices;
use FutureEd\Services\StudentServices;
use FutureEd\Services\UserServices;
use FutureEd\Services\TokenServices;
use FutureEd\Services\AvatarServices;
use Illuminate\Http\Request;
use Illuminate\Routing\Matching\ValidatorInterface;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

trait errorMessage {

    private $error_code = 1000;
    private $field = 'Empty field';
    private $message = 'Empty message';

    public function setErrorCode($error_code){
        $this->error_code = $error_code;
        return $this;
    }

    public function getErrorCode(){
        return $this->error_code;
    }

    public function setField($field){
        $this->field = $field;
        return $this;
    }

    public function getField(){
        return $this->field;
    }

    public function setMessage($message){
        $this->message = $message;
        return $this;
    }

    public function getMessage(){
        return $this->message;
    }

    public function errorMessage(){

        return [
            'error_code' => $this->error_code,
            'field' => $this->field,
            'message' => $this->message
        ];
    }


}


trait apiValidator {

    use errorMessage;

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

                return $this->setErrorCode(1005)
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

                return $this->setErrorCode(1005)
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

                return $this->setErrorCode(1005)
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

                return $this->setErrorCode(1005)
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

                return $this->setErrorCode(1005)
                    ->setField($field_name)
                    ->setMessage($validator_msg["$field_name"][0])
                    ->errorMessage();
            }
        }
    }



}



class ApiController extends Controller {

    private $status_code = Response::HTTP_ACCEPTED;
    private $header = [];

    public function __construct(
            UserServices $user,
            StudentServices $student,
            PasswordImageServices $password_image,
            TokenServices $token,
            MailServices $mailServices,
            ClientServices $client,
            GradeServices $grade,
            AvatarServices $avatar,
            CodeGeneratorServices $code,
            ValidatorRepositoryInterface $validatorRepositoryInterface){
        $this->user = $user;
        $this->student = $student;
        $this->password_image = $password_image;
        $this->token = $token;
        $this->mail = $mailServices;
        $this->client = $client;
        $this->grade = $grade;
        $this->avatar = $avatar;
        $this->code = $code;
        $this->valid = $validatorRepositoryInterface;
    }
    public function index(){
        return [
            'name' => 'FutureEd API',
            'version' => 1
        ];
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->status_code;
    }

    /**
     * @param mixed $status_code
     */
    public function setStatusCode($status_code)
    {
        $this->status_code = $status_code;
        return $this;
    }

    public function getHeader(){
        return $this->header;
    }
    public function setHeader($header){

        $this->header = $header;
        return $this;

    }



    public function respondSuccess($message = 'Success!'){
        return $this->setStatusCode($this->status_code)->respondWithData($message);
    
    }

    public function respondWithData($data){
       
        return $this->respond(
            [
                'status' => $this->getStatusCode(),
                'data' => $data
            ]
        );
    }

    public function respondWithMessage($message){
        return $this->respond(
            [
                'status' => $this->getStatusCode(),
                'data' => $message
            ]
        );
    }




    public function respond($data ){

        return Response()->json($data,$this->getStatusCode(),$this->getHeader());

    }

    public function respondWithError($message = 'Not Found!'){
       
        return $this->respond(
             [
                'status' => $this->getStatusCode(),
                'errors' => $message
            ]
        );

    }



    
}
