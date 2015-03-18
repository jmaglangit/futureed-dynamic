<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Services\StudentServices;
use FutureEd\Services\UserServices;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller {

	private $statusCode = 200;

    public function __construct(UserServices $user, StudentServices $student){
        $this->user = $user;
        $this->student = $student;

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
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }


    public function respondNotFound($message = 'Not Found!'){

        return $this->setStatusCode(404)->respondWithError($message);

    }

    public function respondSuccess($message = 'Success!'){

        return $this->setStatusCode(200)->respondWithData($message);
    }

    public function respondWithData($message){

        return $this->respond(
            [
                'status' => $this->getStatusCode(),
                'data' => $message
            ]
        );
    }

    public function respondWithNoData(){
        return $this->respond(
            [
                'status' => $this->getStatusCode(),
                'data' => 'No Data'
            ]
        );
    }





    public function respond($data, $headers = [] ){

        return Response()->json($data,$this->getStatusCode(),$headers);

    }

    public function respondWithError($message){

        return $this->respond([
            'error' => [
                'status' => $this->getStatusCode(),
                'message' => $message
            ]
        ]);

    }

}
