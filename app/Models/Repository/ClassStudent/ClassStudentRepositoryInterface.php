<?php
namespace FutureEd\Models\Repository\ClassStudent;

interface ClassStudentRepositoryInterface {

    public function getClassStudents($criteria = array(), $limit = 0, $offset = 0);
    public function getClassStudent($id);
    public function addClassStudent($class_student);
    public function updateClassStudent($id,$class_student);
    public function deleteClassStudent($id);
}