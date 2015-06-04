<?php
namespace FutureEd\Models\Repository\ClassStudent;

use FutureEd\Models\Core\ClassStudent;
use FutureEd\Models\Core\Classroom;
use FutureEd\Models\Repository\User\UserRepository;

class ClassStudentRepository implements ClassStudentRepositoryInterface{

    /**
     * @param array $criteria
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getClassStudents($criteria = [], $limit = 0, $offset = 0){

        $class_student = new ClassStudent();

        $class_student = $class_student->with('user');

        if(isset($category['username'])){

            $class_student = $class_student->username($category['username']);
        }

        if(isset($category['email'])){

            $class_student = $class_student->email($category['email']);
        }

        if($offset > 0 && $limit > 0 ){

            $class_student = $class_student->with('user')->skip($offset)->take($limit);
        }

        $records = $class_student->get();
        $count = $class_student->get()->count();

        return [
            'total' => $count,
            'record' => $records
        ];
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
    public function updateClassStudent($id,$class_student){
        
    }
    public function deleteClassStudent($id){
        
    }
    
    public function getClassroom($class_id){
        $classroom = Classroom::find($class_id);
        return !is_null( $classroom ) ? $classroom->toArray() : null;
    }
}