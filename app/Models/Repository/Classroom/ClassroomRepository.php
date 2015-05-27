<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 5/26/15
 * Time: 3:36 PM
 */

namespace FutureEd\Models\Repository\Classroom;


use FutureEd\Models\Core\Classroom;

class ClassroomRepository implements ClassroomRepositoryInterface{

    public function getClassrooms($criteria,$limit,$offset){

        $classroom = new Classroom();
        if(isset($criteria['name'])){

            $classroom = $classroom->name($criteria['name']);
        }

        if(isset($criteria['grade_id'])){

            $classroom = $classroom->grade_id($criteria['grade_id']);
        }

        $classroom = $classroom->with('order','grade','client');

        $count = $classroom->count();

        if($offset > 0 && $limit > 0){
            $classroom = $classroom->skip($offset)->take($limit);
        }

        Return [
            'total' => $count,
            'record' => $classroom->get()
        ];
    }

    public function getClassroom($id){

        return Classroom::with('order','grade','client')->find($id);
    }

    public function addClassroom($data){

        try{

//            Classroom::create();

        }catch(Exception $e){

            return $e->getMessage();
        }

        return true;
    }

    public function updateClassroom($id){

    }

    public function deleteClassroom($id){

    }


}