<?php
namespace FutureEd\Models\Repository\ClassStudent;

interface ClassStudentRepositoryInterface {

    public function checkUserIfExist($email,$user_type);
    public function getClassStudents($criteria = array(), $limit = 0, $offset = 0);
    public function getClassStudent($id);
    public function addClassStudent($class_student);
    public function upateClassStudent($id,$class_student);
    public function deleteClassStudent($id);
}