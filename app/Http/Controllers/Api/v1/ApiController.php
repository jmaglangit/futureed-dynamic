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
use FutureEd\Http\Controllers\Api\Traits\ErrorMessageTrait;
use FutureEd\Http\Controllers\Api\Traits\ApiValidatorTrait;




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
