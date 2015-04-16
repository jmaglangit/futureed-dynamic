<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 4/15/15
 * Time: 5:25 PM
 */

namespace FutureEd\Services;


use FutureEd\Models\Repository\Grade\GradeRepositoryInterface;

class GradeServices {

    public function __construct(GradeRepositoryInterface $gradeRepositoryInterface){
        $this->grade = $gradeRepositoryInterface;


    }

    public function getGrades(){

        return $this->grade->getGrades();

    }

}