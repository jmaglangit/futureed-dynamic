<?php 


namespace FutureEd\Services;


use FutureEd\Models\Repository\School\SchoolRepositoryInterface;

class SchoolServices {
    /**
     *
     */
    public function __construct(
        SchoolRepositoryInterface $school){
        $this->school = $school;
       
    }
    
    //get school details
    
    public function getSchoolName($school_id){
     return  $getSchoolName = $this->school->getSchoolName($school_id);
    }
   

}