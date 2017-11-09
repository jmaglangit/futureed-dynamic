<?php namespace FutureEd\Models\Repository\ParentStudent;


use FutureEd\Models\Core\ParentStudent;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class ParentStudentRepository implements ParentStudentRepositoryInterface{

    use LoggerTrait;

	/**
     * Add record.
     * @param $data
     * @return bool|ParentStudent|static
     */
    public function addParentStudent($data){

        DB::beginTransaction();

        try {

            $parent_student = new ParentStudent();

            $parent_student = $parent_student->create($data);

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $parent_student;
    }

   	/**
     * Check if parent added a specific student.
     * @param $parent_id
     * @param $student_id
     * @return bool|ParentStudent
     */
    public function checkParentStudent($parent_id,$student_id){

        DB::beginTransaction();

        try {
            $parent_student = new ParentStudent();

            $parent_student = $parent_student->parentId($parent_id);
            $parent_student = $parent_student->studentId($student_id)->pluck('id');

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $parent_student;


    }

	/**
     * @param $invitation_code
     * @param $parent_id
     * @return bool|ParentStudent
     */
    public function checkInvitationCode($invitation_code,$parent_id){

        DB::beginTransaction();

        try {
            $parent_student = new ParentStudent();

            $parent_student = $parent_student->invitationCode($invitation_code);
            $parent_student = $parent_student->parentId($parent_id)->first();

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $parent_student;
    }

	/**
     * @param $id
     * @param $data
     * @return bool|\Illuminate\Support\Collection|null|static
     */
    public function updateParentStudent($id,$data){

        DB::beginTransaction();

        try {

            $parent_student = ParentStudent::find($id);

            $parent_student->update($data);

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $parent_student;
    }

	/**
     * @param $criteria
     * @return bool
     */
    public function getParentStudents($criteria)
    {
        DB::beginTransaction();

        try {

            $parentStudent = new ParentStudent();

            if (isset($criteria['parent_id'])) {
                $parentStudent = $parentStudent->parentId($criteria['parent_id']);
            }

            $parentStudent = $parentStudent->with('student')->userConfirmed();

            $response = $parentStudent->get();

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

    /**
     * Delete specific record by id
     *
     * @param  $id
     * @return boolean
     */
    public function deleteParentStudent($id)
    {
        DB::beginTransaction();

        try {

            $result = ParentStudent::find($id);
            $response = !is_null($result) ? $result->delete() : false;

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

    /**
     * Delete records by parent id
     *
     * @param  $parent_id
     * @return boolean
     */
    public function deleteParentStudentByParentId($parent_id)
    {
        DB::beginTransaction();

        try {
            $result = ParentStudent::parentId($parent_id);
            $response = !is_null($result) ? $result->delete() : false;
        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

}