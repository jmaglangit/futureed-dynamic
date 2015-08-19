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
        if (isset($criteria['client_id'])) {

            $classroom = $classroom->client_id($criteria['client_id']);
        }

        if (isset($criteria['name'])) {

            $classroom = $classroom->name($criteria['name']);
        }

        if (isset($criteria['grade_id'])) {

            $classroom = $classroom->grade_id($criteria['grade_id']);
        }

        if (isset($criteria['order_no'])) {

            $classroom = $classroom->order_no($criteria['order_no']);
        }

        $classroom = $classroom->with('order', 'grade', 'client','subject');

        $count = $classroom->get()->count();

        if ($offset >= 0 && $limit > 0) {

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

        $return = Classroom::with('order','grade','client','subject')->find($id);

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

    /**
     *  Delete classrooms by order no.
     *  @param $order_no
     *  @return boolean
     */

    public function deleteClassroomByOrderNo($order_no){
        try{
            return Classroom::order_no($order_no)->delete();
        } catch( Exception $e ){
            return $e->getMessage();
        }
    }

    public function getClassroomByOrderNo($order_no){
        try{
            $result = Classroom::order_no($order_no);
            $result = $result->with('client')->get();
            return !is_null($result) ? $result->toArray():null;
        } catch( Exception $e ){
            return $e->getMessage();
        }
    }

    public function getClassroomBySubjectId($subject_id,$student_id){

        $classroom = new Classroom();

        try{

          $classroom = $classroom->subject_Id($subject_id);
          $classroom = $classroom->active();
          $classroom = $classroom->student_id($student_id);
          $classroom = $classroom->with('classStudent')->get();

          return !is_null($classroom) ? $classroom->toArray():null;

       } catch( Exception $e ){

         return $e->getMessage();
       }

   }


}