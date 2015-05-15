<?php
namespace FutureEd\Models\Repository\Subject;

interface SubjectRepositoryInterface {

    public function getSubjects($criteria = array(), $limit = 0, $offset = 0);
    
    public function addSubject($subject);

}