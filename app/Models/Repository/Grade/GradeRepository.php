<?php namespace FutureEd\Models\Repository\Grade;


use FutureEd\Models\Core\Grade;

class GradeRepository implements GradeRepositoryInterface{


    public function getGrades(){

        return Grade::all();

    }

    public function getGrade($code){

        return Grade::where('code',$code)->first();

    }




}