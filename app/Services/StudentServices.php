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

class StudentServices {

    public function __construct(StudentRepositoryInterface $student, PasswordImageServices $password){
        $this->student = $student;
        $this->password = $password;
    }

    public function getStudents(){

        return $this->student->getStudents();
    }

    public function getStudent($id){
        return $this->student->getStudent($id);
    }

    public function addStudent($student){
        $this->student->addStudent($student);
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

        return $mix;
    }

    public function checkAccess($id,$image_id){
        $password_image = $this->student->getImagePassword($id);

        if($image_id == $password_image){
            return true;
        } else {
            return false;
        }
    }

}