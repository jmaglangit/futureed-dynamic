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

    /**
     * Get list of classroom based with optional pagination.
     * @param $criteria
     * @param $limit
     * @param $offset
     * @return array
     */
    public function getClassrooms($criteria,$limit,$offset){

        $classroom = new Classroom();

		//get client id -- teacher
		if(isset($criteria['client_id'])){

			$classroom = $classroom->client_id($criteria['client_id']);
		}

        if(isset($criteria['name'])){

            $classroom = $classroom->name($criteria['name']);
        }

        if(isset($criteria['grade_id'])){

            $classroom = $classroom->grade_id($criteria['grade_id']);
        }
        
        if(isset($criteria['order_no'])){

            $classroom = $classroom->order_no($criteria['order_no']);
        }
        
        $classroom = $classroom->with('order','grade','client');

        $count = $classroom->get()->count();

		if($offset >= 0 && $limit > 0){

			$classroom = $classroom->skip($offset)->take($limit);
		}

		$records = $classroom->get();

        Return [
            'total' => $count,
            'record' => $records
        ];
    }

    /**
     * Get classroom information.
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection|null|static
     */
    public function getClassroom($id){

        $return = Classroom::with('order','grade','client')->find($id);

        return $return;
    }

    /**
     * Add new classroom.
     * @param $classroom
     * @return string|static
     */
    public function addClassroom($classroom){

        try{

            $classroom = Classroom::create($classroom);

        }catch(Exception $e){

            return $e->getMessage();
        }

        return $classroom;
    }


    /**
     * Update new classroom based on the data needed.
     * @param $id
     * @param $data
     * @return ClassroomRepository|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection|null|string|static
     */
    public function updateClassroom($id,$data){

        try{

            Classroom::find($id)->update($data);

            return $this->getClassroom($id);

        }catch (Exception $e){

            return $e->getMessage();
        }

    }

    /**
     * Delete Classroom
     * @param $id
     */
    public function deleteClassroom($id){

        try{

            return Classroom::find($id)->delete();
        }catch (Exception $e){

            return $e->getMessage();
        }

    }


}