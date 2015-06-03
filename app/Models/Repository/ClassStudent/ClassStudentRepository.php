<?php
namespace FutureEd\Models\Repository\ClassStudent;

use FutureEd\Models\Core\ClassStudent;
use FutureEd\Models\Core\Classroom;
use FutureEd\Models\Repository\User\UserRepository;

class ClassStudentRepository implements ClassStudentRepositoryInterface{
    
    public function getClassStudents($criteria = array(), $limit = 0, $offset = 0){
       
    }
    
    public function getClassStudent($user_id){
        
        return ClassStudent::where('user_id',$user_id)->pluck('user_id');
    }
    
    public function addClassStudent($class_student){
        try{
            return ClassStudent::create($class_student)->toArray();
        }catch(Exception $e){
            return $e->getMessage();        
        }
    }
    public function upateClassStudent($id,$class_student){
        
    }
    public function deleteClassStudent($id){
        
    }
    
    public function getClassroom($class_id){
        $classroom = Classroom::find($class_id);
        return !is_null( $classroom ) ? $classroom->toArray() : null;
    }
}