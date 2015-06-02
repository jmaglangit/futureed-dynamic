<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Controllers\Controller;
use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\ClassStudentRequest;

use FutureEd\Models\Repository\ClassStudent\ClassStudentRepositoryInterface;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;

use FutureEd\Services\CodeGeneratorServices;
use FutureEd\Services\MailServices;
use FutureEd\Services\StudentServices;
use FutureEd\Services\UserServices;

use Illuminate\Http\Request;

class ClassStudentController extends ApiController {

    protected $class_student;
    protected $client;
    protected $code;
    protected $mail;
    protected $student;
    protected $user;    
    
    public function __construct(ClassStudentRepositoryInterface $classStudentRepositoryInterface,
                                ClientRepositoryInterface $clientRepositoryInterface,    
                                CodeGeneratorServices $code,
                                UserServices $userServices,
                                MailServices $mailServices,
                                StudentServices $studentRepositoryInterface)
    {
        $this->class_student = $classStudentRepositoryInterface;
        $this->client = $clientRepositoryInterface;
        $this->code = $code;
        $this->mail = $mailServices;
        $this->student = $studentRepositoryInterface;
        $this->user = $userServices;
    }
	
	public function addNewStudent(ClassStudentRequest $request)
	{
    	 $student = $request->only(
                'first_name',
                'last_name',
                'gender',
                'birth_date',
                'grade_code',
                'country',
                'state',
                'city');
    
            $user = $request->only(
                'username',
                'email',
                'first_name',
                'last_name');
            
            $class_student = $request->only('class_id','client_id');
            
            $callback_uri = $request->only('callback_uri');
            
            //check if username exist
            $check_username = $this->user->checkUsername($user['username'],config('futureed.student'));
    
            //check if email exist
            $check_email = $this->user->checkEmail($user['email'],config('futureed.student'));
    
    
            if($check_username){    
                return $this->respondErrorMessage(2201);
            }
    
            if($check_email){
                return $this->respondErrorMessage(2200);
            }
            
            $user = array_merge($user,[
                'user_type' => config('futureed.student')
            ]);
    
            // add user, return status
            $user_response = $this->user->addUser($user);
            
            
            if(isset($user_response['status'])){
                $student = array_merge($student,[
                    'user_id' => $user_response['id']
                ]);
    
                //add student, resturn status
                $student_response = $this->student->addStudent($student);

            } else {
    
                $return = $user_response;
                return $this->respondErrorMessage($return['error_code']);
    
            }
    
            if(isset($student_response['status'])){
    
                $student_id = $this->student->getStudentId($user_response['id']);
                
                //add class student.                
                $confirmation_code = $this->code->getCodeExpiry();
        	    $class_student['user_id'] = $user_response['id'];
        	    $class_student['verification_code'] = $confirmation_code['confirmation_code'];
            	
            	$this->class_student->addClassStudent($class_student);
        	
                //send email to student.
                $client_user_id = $this->client->checkClient($class_student['client_id'],config('futureed.teacher'));
            	$teacher = $this->user->getUser($client_user_id,config('futureed.client'));
            	
            	$email['user_id'] = $user_response['id'];
            	$email['teacher_name'] = !is_null($teacher) ? $teacher['name'] : "";
            	$email['url'] = $callback_uri['callback_uri'].'?email='.$user['email'];
            	$email['verification_code'] = $confirmation_code['confirmation_code'];
            	
                $this->mail->sendMailInviteStudent($email);
                
                //return success
                return $this->respondWithData([
                    'id' => $student_id
                ]);
            } else {
    
                //TODO: check if this is have been entered.
                $return = array_merge($user_response,$student_response);
    
                return $this->respondWithError($return);    
            }

	}
	
	public function addExistingStudent(ClassStudentRequest $request)
	{	
    	$data = $request->all();
	    $check_email = $this->user->checkEmail($data['email'],config('futureed.student'));
	    
	    if(!$check_email){
        	return $this->respondErrorMessage(2124);// Student does not exist.
    	}
    	
    	$class_student = $this->class_student->getClassStudent($check_email['user_id']);
    	
    	if(!is_null($class_student)){
            return $this->respondErrorMessage(2125);// Student is already in the class.
        }
    	
    	//add to class student table.
    	$confirmation_code = $this->code->getCodeExpiry();
	    $data['user_id'] = $check_email['user_id'];
	    $data['verification_code'] = $confirmation_code['confirmation_code'];
    	$this->class_student->addClassStudent($data);
    	
    	
    	
    	//send email to student.
    	$classroom = $this->class_student->getClassroom($data['class_id']);    	
    	$client_user_id = $this->client->checkClient($data['client_id'],config('futureed.teacher'));    	
    	$teacher = $this->user->getUser($client_user_id,config('futureed.client'));
    	
    	$data['class_name'] = $classroom ? $classroom['name'] : "";
    	$data['teacher_name'] = !is_null($teacher) ? $teacher['name'] : "";
    	            	
    	$this->mail->sendExistingStudentRegister($data);
        
        //return success
        return $this->respondWithData(['id' => $check_email['user_id']]);
    	
	}

}
