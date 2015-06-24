<?php namespace FutureEd\Models\Repository\ParentStudent;


interface ParentStudentRepositoryInterface {

    public function addParentStudent($data);

    public function checkParentStudent($parent_id,$student_id);

    public function checkInvitationCode($invitation_code,$parent_user_id);

    public function updateParentStudent($id,$data);

    public function deleteParentStudent($id);

    public function deleteParentStudentByParentId($parent_id);

    public function getParentStudents($criteria);
}