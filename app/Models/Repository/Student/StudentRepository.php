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
            'country',
            'state',
            'city',
            'grade_code',
            'points',
            'status',
            'avatar_id',
            'learning_style_id',
            'school_code'
        )
            ->where('user_id',$id)->first();

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
               'birth_date' => $student['birthday'],
               'country' => $student['country'],
               'state' => $student['state'],
               'city' => $student['city'],
               'school_code' => $student['school_code'],
               'grade_code' => $student['grade_code'],
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

    public function getImagePassword($user_id){

        return Student::where('user_id','=', $user_id)->pluck('password_image_id');

    }

    //update student_image_password

    public function updateImagePassword($data){
       try{
            Student::where('user_id',$data['id'])
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
        Student::where('user_id',$data['user_id'])
                ->update(['avatar_id'=>$data['avatar_id']]);
    }



}