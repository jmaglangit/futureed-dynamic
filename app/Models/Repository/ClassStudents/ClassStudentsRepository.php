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

    public function getClassroomStudents($class_id,$category,$offset,$limit){

        $class_student = new ClassStudent();

        $class_student = $class_student->with('user');

        if(isset($category['username'])){

            $class_student = $class_student->username($category['username']);
        }

        if(isset($category['email'])){

            $class_student = $class_student->email($category['email']);
        }

        if($offset > 0 && $limit > 0 ){

            $class_student = $class_student->with('user')->skip($offset)->take($limit);
        }

        $records = $class_student->get();
        $count = $class_student->get()->count();

        return [
            'total' => $count,
            'record' => $records
        ];
    }


}