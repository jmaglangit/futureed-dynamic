<?php namespace FutureEd\Models\Repository\Student;

interface StudentRepositoryInterface {

    public function getStudents($criteria = array(), $limit = 0, $offset = 0);

    public function getStudent($id);

    public function getStudentsWithModules($school_code, $subject_id, $grade_level, $teacher_id);

    public function getStudentByUserId($user_id);

    public function getUserId($id);

    public function getStudentDetail($id);

    public function addStudent($student);

    public function deleteStudent($id);

    public function getImagePassword($id);

    public function updateImagePassword($data);

    public function getStudentParent($parent_id);
    
    public function saveStudentAvatar($data);
    
    public function getReferences($id);
    
    public function updateStudentDetails($id,$data);
    
    public function getStudentId($user_id);
    
    public function changePasswordImage($id, $password_image_id);
    
    public function checkIdExist($id);

    public function getStudentList($criteria = [],$limit = 0, $offset = 0);

    public function viewStudent($id);

	public function viewStudentClassBadge($id);

	public function getStudentListByClient($criteria = [], $limit = 0, $offset = 0);

	public function viewStudentByToken($id,$reg_token);

	public function subscriptionExpired($id);

	public function updateSchool($id,$school_code);

    public function addStudentFromFacebook($data);

    public function getStudentByFacebook($facebook_id);

    public function addStudentFromGoogle($data);

    public function getStudentByGoogleId($google_id);

    public function getStudentPoints($student_id);

    public function getStudentPointsUsed($user_id);

    public function getStudentLSP($student_id);

    public function getStudentLSPDate($student_id);

    public function updateStudentPointsUsed($id,$points);

    public function getStudentPlay($id);

    public function getStudentCountry($id);
}