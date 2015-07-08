<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/6/15
 * Time: 5:38 PM
 */

namespace FutureEd\Services;


use Carbon\Carbon;
use FutureEd\Models\Repository\ClassStudent\ClassStudentRepositoryInterface;
use FutureEd\Models\Repository\Grade\GradeRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\PasswordImage\PasswordImageRepositoryInterface;
use FutureEd\Models\Repository\User\UserRepositoryInterface;
use FutureEd\Models\Repository\Validator\ValidatorRepository;
use FutureEd\Services\SchoolServices;
use FutureEd\Services\AvatarServices;

class StudentServices {

    public function __construct(
            StudentRepositoryInterface $student,
            PasswordImageServices $password,
            UserServices $user,
            ValidatorRepository $validator,
            SchoolServices $school,
            AvatarServices $avatar,
            GradeRepositoryInterface $gradeRepositoryInterface,
			ClassStudentRepositoryInterface $classStudentRepositoryInterface
            ){
        $this->student = $student;
        $this->password = $password;
        $this->user = $user;
        $this->validator = $validator;
        $this->school = $school;
        $this->avatar = $avatar;
        $this->grade = $gradeRepositoryInterface;
		$this->class_student = $classStudentRepositoryInterface;
        }

    public function getStudents($criteria , $limit , $offset ){

        return $this->student->getStudents($criteria , $limit , $offset);
    }

    public function getStudent($id){
        return $this->student->getStudent($id);
    }

    /*
     * @desc Add new student
     *  'first_name',
            'last_name',
            'gender',
            'birthday',
            'school_code',
            'grade_code',
            'country',
            'state',
            'city'
     */
    //TODO: Add more validations on the each data variables.
    public function addStudent($student){

        $return = [];

        if(empty(array_filter($return))){
            //if existing add student
            $student_response = $this->student->addStudent($student);

            // if not add user and add student

            return [
                'status' => 200,
                'message' => $student_response
            ];
        }

        return $return;
    }

    public function updateStudent($student){
        $this->student->updateStudent($student);
    }

    public function deleteStudent($id){
        $this->student->deleteStudent($id);
    }

    public function getImagePassword($id){

        //TODO: get image password.
        $imgId= $this->student->getImagePassword($id);
        if(is_null($imgId)){

            return false;
        }
        //mix password id with selections
        $mix = $this->password->getMixImage($imgId);


        shuffle($mix);

        return [
            'status' => 200,
            'data' => $mix
        ];
    }

    /*
     * @param id
     * @param image_id
     * @param token
     * @desc id is the student id, image_id is the image password, token is optional if it has a token.
     * token is the indicator if it has login.
     */
    public function checkAccess($id,$image_id, $token = null){

        $user_id = $this->student->getReferences($id);
        $is_disabled =  $this->user->checkUserDisabled($user_id['user_id']);

        if(!$is_disabled){
            $password_image = $this->student->getImagePassword($id);

            if($image_id == $password_image){
                $this->user->resetLoginAttempt($user_id['user_id']);
                return [
                    'status' => 200,
                    'data' => true
                ];
            } else {

                //check if token has values.
                if(!$token){

                    $this->user->addLoginAttempt($user_id['user_id']);
                }

                if(!$this->user->exceedLoginAttempts($user_id['user_id'])){
                    $this->user->lockAccount($user_id['user_id']);
                    return [
                        'status' => $this->user->checkUserDisabled($user_id['user_id'])
                    ];
                }
                return [
                    'status' => 2012
                ];
            }
        } else {
            return [
                'status' => $is_disabled
            ];
        }
    }


    public function getStudentDetails($id){

		$student = $this->getStudent($id)->toArray();
		$student_reference = $this->student->getReferences($id)->toArray();

		//get age
		$age = $this->age($student['birth_date']);

		//get user username and email
		$user = $this->user->getUsernameEmail($student['user_id'])->toArray();

		$avatar_url = '';

		if ($student_reference['avatar_id']) {
			$avatar = $this->avatar->getAvatar($student_reference['avatar_id'])->toArray();
			$avatar_url = $this->avatar->getAvatarUrl($avatar['avatar_image']);
		}

		$school = '';

		if ($student_reference['school_code']) {
			$school = $this->school->getSchoolName($student_reference['school_code']);
		}

		//get grade name
		if ($student_reference['grade_code']) {

			$grade = $this->grade->getGrade($student_reference['grade_code']);
		}




		$student = array_merge(array('id' => $id
			,'class_id' => $this->getCurrentClass($id))
			, $student
			, $user,
			array('age' => $age,
				'avatar' => $avatar_url,
				'school' => $school,
				'grade' => isset($grade) ? $grade['name'] : null,
				'avatar_id' => $student_reference['avatar_id']));


		foreach ($student as $key => $value) {
			if ($key != 'user_id') {
				$studentdetails[$key] = $value;
			}
		}
		return $studentdetails;

    }
    
    //get age
    public function age($birth_date){
         $interval = date_diff(date_create(),date_create($birth_date));
         return $interval->format("%Y");
    }

    //get student birth_date
    public function getAge($id){

        $student = $this->student->getStudent($id);

        $age = Carbon::now();

        return $age->diffInYears(Carbon::parse($student['birth_date']));

    }
    
    //udpate student_image_password
    public function resetPasswordImage($data){
        
        $this->student->updateImagePassword($data);
        $return = ['status'=>200,
                    'data' =>$data['id']];
        return $return;
    }


    public function getStudentByParent($parent_id){
        return $this->student->getStudentParent($parent_id);
    }
    
    //save student avatar
    public function saveStudentAvatar($data){
        
        return $this->student->saveStudentAvatar($data);
        
    }
    
    //validation email/username/firstname/lastname/gender
    public function validateStudentDetails($input){
        
        if(!$this->validator->gender($input['gender'])){
            
            return['status'=>202,
                    'data'=>'invalid gender'];
        }else{
           
            if(!$this->validator->email($input['email'])){
               
                return['status'=>202,
                    'data'=>'invalid email'];
            }else{
               
                if(!$this->validator->username($input['username'])){
                     
                     return['status'=>202,
                    'data'=>'invalid username'];  
                }else{
                    
                    return['status'=>200];
                }
                
            }
            
        }
    }
    
    public function updateStudentDetails($id,$input){
        
        $student_reference = $this->student->getReferences($id)->toArray();
        
        //update user username and email
        $this->user->updateUsernameEmail($student_reference['user_id'],$input);
        
        //update Student details
        $this->student->updateStudentDetails($id,$input);
    }
    
    
     //format return for student reset code
    public function resetCodeResponse($user_id){
        $id = $this->student->getStudentId($user_id);
        $return=['id'=>$id,
                 'user_type'=>'Student',
                ];
        return $return;
    }


    //get student references
    public function getStudentReferences($id){

        return $this->student->getReferences($id);
    }


    //get student id
    public function getStudentId($user_id){

        return $this->student->getStudentId($user_id);
    }
    
    //change password images
    public function changePasswordImage($id,$password_image_id){
        
        $this->student->changePasswordImage($id,$password_image_id);
        
    }
    
    //check if id exist
    public function checkIdExist($id){
        
        return $this->student->checkIdExist($id);
    }

	public function updateSchool($id,$school_code){

		return $this->student->updateSchool($id,$school_code);
	}

	/**
	 * Student relationship to class
	 * Get current class of the student
	 * @param $student_id
	 * @return int
	 */
	public function getCurrentClass($student_id)
	{
		//get all active class.
		$active_class = $this->class_student->getActiveClassStudent($student_id);

		//mitigate to inactive
		foreach ($active_class as $list => $class) {



			if (!(Carbon::now()->between(
				Carbon::parse($class->classroom->order->date_start),
				Carbon::parse($class->classroom->order->date_end)))
			) {

				$this->class_student->setClassStudentInactive($class->id);

			}
		}

		//get inactive class whose class time has today.
		$inactive_class = $this->class_student->getInactiveClassStudent($student_id);

		//mitigate to active
		foreach ($inactive_class as $list => $class) {

			if (Carbon::now()->between(
				Carbon::parse($class->classroom->order->date_start),
				Carbon::parse($class->classroom->order->date_end))
			) {

				$this->class_student->setClassStudentActive($class->id);
			}
		}

		$class_student = $this->class_student->getStudentCurrentClassroom($student_id);

		return ($class_student) ? $class_student : 0;
	}


    
    
}