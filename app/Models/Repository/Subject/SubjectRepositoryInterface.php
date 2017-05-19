<?php
namespace FutureEd\Models\Repository\Subject;

interface SubjectRepositoryInterface {

    public function getSubjects($criteria = array(), $limit = 0, $offset = 0);
    
    public function addSubject($subject);
    
    public function getSubject($id);
    
    public function updateSubject($id, $subject);
    
    public function deleteSubject($id);

    public function getASubjectWithModules($subject_id, $grade_level);

    public function getASubjectWithAreas($subject_id, $grade_level);

    public function getSubjectsWithModules($grade_level);

}