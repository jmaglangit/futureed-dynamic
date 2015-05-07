<?php namespace FutureEd\Models\Repository\Grade;


interface GradeRepositoryInterface {

    public function getGrades();

    public function getGrade($code);

}