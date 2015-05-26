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

        if(isset($criteria['name'])){

            $classroom = Classroom::with('client','grade','order')->name($criteria['name']);
        } else {

            $classroom =  Classroom::with('client','grade','order');
        }

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