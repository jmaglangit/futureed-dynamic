<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Services\ClientServices;
use FutureEd\Services\GradeServices;
use FutureEd\Services\MailServices;
use FutureEd\Services\PasswordImageServices;
use FutureEd\Services\StudentServices;
use FutureEd\Services\UserServices;
use FutureEd\Services\TokenServices;
use FutureEd\Services\AvatarServices;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller {

    private $status_code = 200;

    public function __construct(
            UserServices $user,
            StudentServices $student,
            PasswordImageServices $password_image,
            TokenServices $token,
            MailServices $mailServices,
            ClientServices $client,
            GradeServices $grade,
            AvatarServices $avatar){
        $this->user = $user;
        $this->student = $student;
        $this->password_image = $password_image;
        $this->token = $token;
        $this->mail = $mailServices;
        $this->client = $client;
        $this->grade = $grade;
        $this->avatar = $avatar;
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



    public function respondSuccess($message = 'Success!'){
        return $this->setStatusCode(Response::HTTP_ACCEPTED)->respondWithData($message);
    
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




    public function respond($data, $headers = [] ){
      
        return Response()->json($data,$this->getStatusCode(),$headers);

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
