<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 5/29/15
 * Time: 11:39 AM
 */

namespace FutureEd\Models\Repository\ClassStudents;

interface ClassStudentsRepositoryInterface {

    public function getClassroomStudents($class_id,$category,$offset,$limit);

}