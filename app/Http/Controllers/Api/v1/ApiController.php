<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Controllers\Api\Traits\AccessTokenTrait;
use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Admin\AdminRepositoryInterface;
use FutureEd\Models\Repository\ClientDiscount\ClientDiscountRepositoryInterface;
use FutureEd\Models\Repository\Country\CountryRepositoryInterface;
use FutureEd\Models\Repository\School\SchoolRepositoryInterface;
use FutureEd\Models\Repository\Validator\ValidatorRepositoryInterface;
use FutureEd\Services\ClientServices;
use FutureEd\Services\CodeGeneratorServices;
use FutureEd\Services\EquationCompilerServices;
use FutureEd\Services\GradeServices;
use FutureEd\Services\MailServices;
use FutureEd\Services\PasswordImageServices;
use FutureEd\Services\QuestionCacheServices;
use FutureEd\Services\StudentServices;
use FutureEd\Services\SchoolServices;
use FutureEd\Services\UserServices;
use FutureEd\Services\TokenServices;
use FutureEd\Services\AvatarServices;
use FutureEd\Services\AdminServices;
use FutureEd\Services\PasswordServices;
use FutureEd\Services\QuestionTemplateServices;
use Illuminate\Http\Request;
use Illuminate\Routing\Matching\ValidatorInterface;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use FutureEd\Http\Controllers\Api\Traits\ErrorMessageTrait;
use FutureEd\Http\Controllers\Api\Traits\ApiValidatorTrait;
use FutureEd\Http\Controllers\Api\Traits\ClientValidatorTrait;




class ApiController extends Controller {

    use ApiValidatorTrait;
    use AccessTokenTrait;

    private $status_code = Response::HTTP_OK;
    private $header = [];

	//TODO: To be removed.
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
		AdminRepositoryInterface $admin,
		PasswordServices $password,
		ValidatorRepositoryInterface $validatorRepositoryInterface,
		SchoolRepositoryInterface $schoolRepositoryInterface,
		CountryRepositoryInterface $countryRepositoryInterface,
		ClientDiscountRepositoryInterface $clientDiscountRepositoryInterface,
        EquationCompilerServices $equationCompilerServices,
        QuestionCacheServices $questionCacheServices)
	{
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
		$this->password = $password;
		$this->valid = $validatorRepositoryInterface;
		$this->school = $schoolRepositoryInterface;
		$this->country = $countryRepositoryInterface;
		$this->client_discount = $clientDiscountRepositoryInterface;
        $this->equation = $equationCompilerServices;
        $this->question_cache = $questionCacheServices;
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
        $error_msg = trans('errors');

        if(!is_null($error_code)){

            $return = $this->setErrorCode($error_code)
                    ->setMessage($error_msg[$error_code])
                    ->errorMessageCommon();


            $this->addMessageBag($return);

            return $this->respondWithError($this->getMessageBag());
        }

    }

    public function textFunction(){

//        $answer = [1,2,3,4,5];
        $answer = [8,120,900,15000,90000];
//        array:5 [
//            0 => 8
//  1 => 120
//  2 => 900
//  3 => 15000
//  4 => 90000
//]
//        return $this->equation->solve($answer,Input::get('question_cache'));
        return $this->question_cache->generateQuestions(Input::get('module_id'));
    }



    
}
