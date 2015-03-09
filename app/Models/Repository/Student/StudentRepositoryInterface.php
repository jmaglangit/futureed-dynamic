<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/6/15
 * Time: 11:30 AM
 */
namespace FutureEd\Models\Repository\Student;

interface StudentRepositoryInterface {

    public function getStudents();

    public function getStudent($id);

    public function addStudent($student);

    public function updateStudent($student);

    public function deleteStudent($id);

}