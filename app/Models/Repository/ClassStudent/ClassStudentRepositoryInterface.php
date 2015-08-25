<?php
namespace FutureEd\Models\Repository\ClassStudent;

interface ClassStudentRepositoryInterface {

	public function getClassStudents($criteria = array(), $limit = 0, $offset = 0);

	public function getClassStudent($id);

	public function addClassStudent($class_student);

	public function updateClassStudent($id, $class_student);

	public function deleteClassStudent($id);

	public function getStudentCurrentClassroom($student_id);

	public function getActiveClassStudent($student_id);

	public function setClassStudentInactive($id);

	public function getInactiveClassStudent($student_id);

	public function setClassStudentActive($id);

	public function isEnrolled($id,$class_id);

	public function getClassStudentByClassId($class_id);


}