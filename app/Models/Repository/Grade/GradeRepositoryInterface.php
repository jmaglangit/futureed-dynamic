<?php namespace FutureEd\Models\Repository\Grade;


interface GradeRepositoryInterface {

    public function getGrades();

    public function getGrade($code);

    public function addGrade($grade);

    public function updateGrade($id,$data);

    public function deleteGrade($id);

    public function getGradeById($id);

    public function getStudentByCode($id);

    public function getClientByUserId($user_id);


}