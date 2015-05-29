<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 5/29/15
 * Time: 11:40 AM
 */

namespace FutureEd\Models\Repository\ClassStudents;


use FutureEd\Models\Core\ClassStudent;
use FutureEd\Models\Repository\Classroom\ClassroomRepositoryInterface;

class ClassStudentsRepository implements ClassStudentsRepositoryInterface{

    public function getClassroomStudents($class_id){

        return ClassStudent::with('user')->Classroom($class_id)->get();
    }


}