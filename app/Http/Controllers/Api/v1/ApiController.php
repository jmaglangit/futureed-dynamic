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

        if(empty($this->messageBag)){
            $this->setMessageBag([$message]);
        } elseif(!empty($message)) {
            $this->messageBag = array_merge(
                $this->getMessageBag(),
                [$message]
            );
        }
    }

    //Check parameters of the fields.
    public function parameterCheck($input, $paramName){

        if(is_null($input["$paramName"])){

            $return  = $this->setErrorCode(1001)
                        ->setField($paramName)
                        ->setMessage("Required field not found.")
                        ->errorMessage();


        } elseif(empty($input["$paramName"])){

            $return = $this->setErrorCode(1002)
                        ->setField($paramName)
                        ->setMessage("Empty required field.")
                        ->errorMessage();
        }
        return $return;
    }

    //Check email validations.
    public function email($input, $email){

        if(!is_null($input["$email"]) && !empty($input["$email"])){
            $validator = Validator::make(
                [
                    "$email" => $email,
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
        return $this->parameterCheck($input,$email);
    }

    //Check username validations.
    public function username($input,$username){

        if(!is_null($input["$username"]) && !empty($input["$username"])){

            $validator = Validator::make(
                [
                    "$username" => $username
                ],
                [
                    "$username" => 'required|min:8|max:32|alpha_num'
                ]
            );

            if($validator->fails()){

                $validator_msg = $validator->messages()->toArray();

                    return $this->setErrorCode(1004)
                            ->setField($username)
                            ->setMessage($validator_msg)
                            ->errorMessage();

            }
        }
        return $this->parameterCheck($input,$username);
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
