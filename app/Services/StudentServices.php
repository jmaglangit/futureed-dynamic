<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/6/15
 * Time: 5:38 PM
 */

namespace FutureEd\Services;


use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\PasswordImage\PasswordImageRepositoryInterface;
use FutureEd\Models\Repository\User\UserRepositoryInterface;
use FutureEd\Models\Repository\Validator\ValidatorRepository;
use FutureEd\Services\SchoolServices;

class StudentServices {

    public function __construct(
            StudentRepositoryInterface $student,
            PasswordImageServices $password,
            UserServices $user,
            ValidatorRepository $validator,
            SchoolServices $school){
        $this->student = $student;
        $this->password = $password;
        $this->user = $user;
        $this->validator = $validator;
        $this->school = $school;
    }

    public function getStudents(){

        return $this->student->getStudents();
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

        //validate datas
        if($this->validator->gender($student['gender'])){
            $return = array_merge($return,[
                'error_code' => 400028,
                'message' => 'Gender not verified'
            ]);
        }

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

        //mix password id with selections
        $mix = $this->password->getMixImage($imgId);


        shuffle($mix);

        return [
            'status' => 200,
            'data' => $mix
        ];
    }

    public function checkAccess($id,$image_id){
        $is_disabled =  $this->user->checkUserDisabled($id);

        if(!$is_disabled){
            $password_image = $this->student->getImagePassword($id);

            if($image_id == $password_image){
                $this->user->resetLoginAttempt($id);
                return [
                    'status' => 200,
                    'data' => true
                ];
            } else {
                $this->user->addLoginAttempt($id);
                if(!$this->user->exceedLoginAttempts($id)){
                    $this->user->lockAccount($id);
                    return [
                        'status' => 202,
                        'data' => $this->user->checkUserDisabled($id)
                    ];
                }
                return [
                    'status' => 202,
                    'data' => "does not match"
                ];
            }
        } else {
            return [
                'status' => 202,
                'data' => $is_disabled
            ];
        }
    }


    public function getStudentDetails($id){
        
        $student = $this->getStudent($id)->toArray();
        $student_reference = $this->student->getReferences($id)->toArray();
        
        //get age
        $age = $this->age($student['birth_date']);
        
        //get user username and email
        $user = $this->user->getUsernameEmail($id)->toArray();
        
        //get avatar url
        $password_image_url =$this->password->getUserPasswordImageUrl($id);
        
        //get school
        $school=$this->school->getSchoolName($student_reference['school_code']);
        $student = array_merge(array('id'=>$id),$student,$user,
                               array('age'=>$age,
                                     'avatar'=>$password_image_url,
                                     'school'=>$school));
        
        
        foreach ($student as $key => $value) {
            if($key!='user_id'){
               $studentdetails[$key]=$value; 
            }
        }
        return $studentdetails;

    }
    
    //get age
    public function age($birth_date){
         $interval = date_diff(date_create(),date_create($birth_date));
         return $interval->format("%Y");
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
    public function saveStudentAvatar($input){
        $this->student->saveStudentAvatar($input);
        return $input['id'];
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
    
    
}