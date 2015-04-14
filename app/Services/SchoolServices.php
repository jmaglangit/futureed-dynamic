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
    
    public function getSchool($school_id){
      $school_details = $this->school->getSchool($school_id);
    }
   

}