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

	public function getClassStudentById($id);

	public function getCurrentClassStudent($criteria);

	public function getClassStudentStanding($student_id);

	public function getStudentModulesProgressByGrade($student_id,$subject_id, $country_id);

	public function getStudentModulesCompleted($student_id,$subject_id, $country_id);

	public function getStudentModulesTotalHours($student_id,$subject_id, $country_id);

	public function getStudentModulesWeekHours($student_id,$subject_id, $country_id);

	public function getStudentSubjectProgressByCurriculum($student_id, $subject_id, $class_id);

	public function getStudentValidClassBySubject($student_id, $subject_id);

	public function getStudentCurrentLearning($student_id,$subject_id, $country_id);

	public function getStudentValidModule($student_id, $module_id, $country_id);


}