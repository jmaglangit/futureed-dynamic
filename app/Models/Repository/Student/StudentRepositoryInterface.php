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
    
    public function ChangPasswordImage($id,$password_image_id);
    
    public function checkIdExist($id);

    public function getStudentList($criteria = [],$limit = 0, $offset = 0);

    public function viewStudent($id);

	public function viewStudentClassBadge($id);

}