<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 5/26/15
 * Time: 3:37 PM
 */

namespace FutureEd\Models\Repository\Classroom;


interface ClassroomRepositoryInterface {

    public function getClassrooms($criteria,$limit,$offset);

    public function getClassroom($id);

    public function addClassroom($data);

    public function updateClassroom($id,$data);

    public function deleteClassroom($id);

    public function deleteClassroomByOrderNo($order_no);

    public function updateClassroomByOrderNo($order_no, $data);

    public function getClassroomByOrderNo($order_no);

    public function getClassroomBySubjectId($subject_id, $student_id);

    public function checkClassroomActive($class_id);

    public function getActiveSubscription($subject_id,$student_id,$school_country);

}