<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/6/15
 * Time: 11:30 AM
 */
namespace FutureEd\Models\Repository\Student;

interface StudentRepositoryInterface {

    public function getStudents($criteria = array(), $limit = 0, $offset = 0);

    public function getStudent($id);

    public function getStudentDetail($id);

    public function addStudent($student);

    public function updateStudent($student);

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

    public function addStudentFromGoogle($data);


}