<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/6/15
 * Time: 5:38 PM
 */

namespace App\Services;


use App\Futureed\Repository\Student\StudentRepositoryInterface;

class StudentServices {

    public function __construct(StudentRepositoryInterface $student){
        $this->student = $student;
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

}