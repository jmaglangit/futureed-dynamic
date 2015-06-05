<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/6/15
 * Time: 11:30 AM
 */
namespace FutureEd\Models\Repository\Student;

use FutureEd\Models\Core\Student;
use FutureEd\Models\Core\User;
use League\Flysystem\Exception;

class StudentRepository implements StudentRepositoryInterface{

    public function getStudents(){

    }

    //get student basic details
    public function getStudent($id){

        return Student::select(
            'user_id',
            'first_name',
            'last_name',
            'gender',
            'birth_date',
            'country_id',
            'country',
            'state',
            'city',
            'points',
            'status',
            'learning_style_id',
            'grade_code'
        )
            ->where('id',$id)->first();

    }

    //get student details
    public function getStudentDetail($id){

        return Student::where('user_id',$id)->first();

    }

    public function addStudent($student){
        try {
//            user_id
//            first_name
//            last_name
//            gender
//            birth_date
//            avatar_id
//            password_image_id
//            school_code
//            grade_code
//            point_level_id
//            learning_style_id
//            status

//            'first_name',
//            'last_name',
//            'gender',
//            'birthday',
//            'school_code',
//            'grade_code',
//            'country',
//            'state',
//            'city'
           Student::insert([
               'user_id' => $student['user_id'],
               'first_name' => $student['first_name'],
               'last_name' => $student['last_name'],
               'gender' => $student['gender'],
               'birth_date' => $student['birth_date'],
               'country_id' => $student['country_id'],
               'country' => $student['country'],
               'state' => $student['state'],
               'city' => $student['city'],
               'grade_code' => $student['grade_code'],
               'school_code' => (isset($student['school_code'])) ? $student['school_code'] : NULL,
               'status' => 'Disabled',
               'created_by' => 1,
               'updated_by' => 1
           ]);

        } catch (Exception $e){
            throw new Exception ($e->getMessage());
        }
        return true;

    }

    public function updateStudent($id){

    }

    public function deleteStudent($id){

    }

    public function getImagePassword($id){

        return Student::where('id','=', $id)->pluck('password_image_id');

    }

    //update student_image_password

    public function updateImagePassword($data){
      
       try{
            Student::where('id',$data['id'])
                     ->update(['password_image_id'=>$data['password_image_id']]);
        } catch (Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    //get student according to parent id.
    public function getStudentParent($parent_id){

        //student_id,
        //avatar_id,
        //avatar_url,
        //first_name,
        //last_name
        return Student::select('id','avatar_id','first_name','last_name')
            ->where('parent_id','=',$parent_id)->get()->toArray();

    }
    
    //save student avatar
    public function saveStudentAvatar($data){
        
      try{
            Student::where('id',$data['id'])
                ->update(['avatar_id'=>$data['avatar_id']]);
                
            return true;     
                
        } catch (Exception $e){
          
            throw new Exception($e->getMessage());
            
        }
   
        
       
          
        
    }
    
    //get foreign key of student table grade_code,avatar_id,school_code,learning_style_id
    public function getReferences($id){
      
      return Student::select(
            'user_id',
            'grade_code',
            'avatar_id',
            'school_code',
            'learning_style_id',
            'password_image_id'
            )->where('id','=',$id )->first();
    }
    
    //update student details 
    public function updateStudentDetails($id,$data){
            Student::where('id','=',$id)
                     ->update(['first_name'=>$data['first_name'],

                               'last_name'=>$data['last_name'],
                               'gender'=>$data['gender'],
                               'birth_date'=>$data['birth_date'],
                               'grade_code'=>$data['grade_code'],
                               'school_code' => (isset($data['school_code'])) ? $data['school_code'] : NULL,
                               'country'=>$data['country'],
                               'city'=>$data['city'],
                               'state'=>$data['state']]);
    }
    
    
    //return student id 
    public function getStudentId($user_id){
       return  Student::where('user_id','=',$user_id)->pluck('id');
    }
    
    
    //change password_image_id
    public function ChangPasswordImage($id,$password_image_id){

       try{
            Student::where('id',$id)
                     ->update(['password_image_id'=>$password_image_id]);
        } catch (Exception $e){
            throw new Exception($e->getMessage());
        }
        
    }
    
    //check if id exist
    public function checkIdExist($id){
      
            return Student::where('id',$id)
                              ->pluck('id');
    }

    public function getStudentList($criteria = [],$limit = 0, $offset = 0){


        $student = new Student();
        $count = 0;

        if(count($criteria) <= 0 && $limit == 0 && $offset == 0) {

            $count = $student->count();

        } else {

            if(count($criteria) > 0) {
                if(isset($criteria['name'])) {

                    $student = $student->with('user')->name($criteria['name']);

                }
                if(isset($criteria['email'])) {

                    $student = $student->with('user')->email($criteria['email']);

                }

            }

            $count = $student->count();

            if($limit > 0 && $offset >= 0) {
                $student = $student->with('user')->offset($offset)->limit($limit);
            }

        }

        $student = $student->with('user')->orderBy('last_name', 'asc');

        return ['total' => $count, 'records' => $student->get()->toArray()];




    }

    //get student with relation to classroom and grade tables
    public function viewStudent($id){

        $student = new Student();

        $student = $student->with('user','school','grade')->where('id',$id)->orderBy('created_at', 'desc');

        $student = $student->first();

        return $student;

        
    }

    

}