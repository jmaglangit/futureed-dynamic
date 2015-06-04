<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 5/26/15
 * Time: 3:36 PM
 */

namespace FutureEd\Models\Repository\Classroom;


use FutureEd\Models\Core\Classroom;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;

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



        if($offset > 0 && $limit > 0){
            $classroom = $classroom->skip($offset)->take($limit);
        }

        $records = $classroom->get();
        $count = $classroom->get()->count();

        Return [
            'total' => $count,
            'record' => $records
        ];
    }

    public function getClassroom($id){

        $return = Classroom::with('order','grade','client')->find($id);

        return $return;
    }

    public function addClassroom($classroom){

        try{

            $classroom = Classroom::create($classroom);

        }catch(Exception $e){

            return $e->getMessage();
        }

        return $classroom;
    }


    public function updateClassroom($id,$data){

        try{

            Classroom::id($id)->update($data);

            return $this->getClassroom($id);

        }catch (Exception $e){

            return $e->getMessage();
        }

    }

    public function deleteClassroom($id){

    }


}