<?php
namespace FutureEd\Models\Repository\SubjectArea;

interface SubjectAreaRepositoryInterface {

	public function getAreasBySubjectId($subject_id);

    public function getSubjectAreas($criteria = array(), $limit = 0, $offset = 0);
    
    public function addSubjectArea($subject_area);
    
    public function getSubjectArea($id);
    
    public function updateSubjectArea($id, $subject_area);
    
    public function deleteSubjectArea($id);

}