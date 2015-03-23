<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/6/15
 * Time: 11:30 AM
 */
namespace FutureEd\Models\Repository\Student;

use FutureEd\Models\Core\Student;
use League\Flysystem\Exception;

class StudentRepository implements StudentRepositoryInterface{

    public function getStudents(){

    }

    public function getStudent($id){

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
//            points
//            point_level_id
//            learning_style_id
//            status
            \DB::table('students')->insert([
                [

                ]
            ]);

        } catch (Exception $e){
            throw new Exception ($e->getMessage());
        }

    }

    public function updateStudent($id){

    }

    public function deleteStudent($id){

    }

    public function getImagePassword($id){

        return Student::where('user_id','=',$id)->pluck('password_image_id');

    }


}