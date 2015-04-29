<?php 


namespace FutureEd\Services;


use FutureEd\Models\Repository\School\SchoolRepositoryInterface;

class SchoolServices {
    /**
     *
     */
    public function __construct(
        SchoolRepositoryInterface $schools){
        $this->schools = $schools;
       
    }
    
    //get school details
    
    public function getSchoolName($school_id){

     return  $getSchoolName = $this->schools->getSchoolName($school_id);
    }

   public function addSchool($school){
        $return = [];

        $addschool_response = $this->schools->addSchool($school);

        $school_id = $this->schools->getSchoolId($school['school_name']);

        $return = [
            'status'    => 200,
            'id'        => $school_id,
            'message'   => $addschool_response,
        ];

        return $return;
   }

}