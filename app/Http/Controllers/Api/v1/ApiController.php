<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Country\CountryRepositoryInterface;
use FutureEd\Models\Repository\School\SchoolRepositoryInterface;
use FutureEd\Models\Repository\Validator\ValidatorRepositoryInterface;
use FutureEd\Services\ClientServices;
use FutureEd\Services\CodeGeneratorServices;
use FutureEd\Services\GradeServices;
use FutureEd\Services\MailServices;
use FutureEd\Services\PasswordImageServices;
use FutureEd\Services\StudentServices;
use FutureEd\Services\SchoolServices;
use FutureEd\Services\UserServices;
use FutureEd\Services\TokenServices;
use FutureEd\Services\AvatarServices;
use FutureEd\Services\AdminServices;
use Illuminate\Http\Request;
use Illuminate\Routing\Matching\ValidatorInterface;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use FutureEd\Http\Controllers\Api\Traits\ErrorMessageTrait;
use FutureEd\Http\Controllers\Api\Traits\ApiValidatorTrait;
use FutureEd\Http\Controllers\Api\Traits\ClientValidatorTrait;




class ApiController extends Controller {

    use ApiValidatorTrait;

    private $status_code = Response::HTTP_OK;
    private $header = [];

    public function __construct(
            UserServices $user,
            StudentServices $student,
            SchoolServices $school,
            PasswordImageServices $password_image,
            TokenServices $token,
            MailServices $mailServices,
            ClientServices $client,
            GradeServices $grade,
            AvatarServices $avatar,
            CodeGeneratorServices $code,
            AdminServices $admin,
            ValidatorRepositoryInterface $validatorRepositoryInterface,
            SchoolRepositoryInterface $schoolRepositoryInterface,
            CountryRepositoryInterface $countryRepositoryInterface){
        $this->user = $user;
        $this->student = $student;
        $this->school = $school;
        $this->password_image = $password_image;
        $this->token = $token;
        $this->mail = $mailServices;
        $this->client = $client;
        $this->grade = $grade;
        $this->avatar = $avatar;
        $this->code = $code;
        $this->admin = $admin;
        $this->valid = $validatorRepositoryInterface;
        $this->school = $schoolRepositoryInterface;
        $this->country = $countryRepositoryInterface;
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

    public function respondErrorMessage($error_code){
        $error_msg  = config('futureed-error.error_messages');

        if(!is_null($error_code)){

            $return = $this->setErrorCode($error_code)
                    ->setMessage($error_msg[$error_code])
                    ->errorMessageCommon();


            $this->addMessageBag($return);

            return $this->respondWithError($this->getMessageBag());
//            return $this->respondWithError(
//                    [
//                        'error_code' => $error_code,
//                        'message' => $error_msg[$error_code]
//                    ]
//                );
        }

    }



    
}
