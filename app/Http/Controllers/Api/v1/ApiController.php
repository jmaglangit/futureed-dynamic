<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Services\MailServices;
use FutureEd\Services\PasswordImageServices;
use FutureEd\Services\StudentServices;
use FutureEd\Services\UserServices;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller {

    private $status_code = 200;

    public function __construct(
            UserServices $user,
            StudentServices $student,
            MailServices $mail,
            PasswordImageServices $password_image){
        $this->user = $user;
        $this->student = $student;
        $this->mail = $mail;
        $this->password_image = $password_image;
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

        return $this->respond([
            'error' => [
                'status' => $this->getStatusCode(),
                'message' => $message
            ]
        ]);

    }

}
