<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Core\Classroom;
use FutureEd\Models\Repository\Classroom\ClassroomRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use FutureEd\Http\Requests\Api\ClassroomRequest;

class ClassroomController extends ApiController {

    protected $classroom;

    public function __construct(ClassroomRepositoryInterface $classroomRepositoryInterface){

        $this->classroom = $classroomRepositoryInterface;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $criteria = [];

        //get client id -- teacher
        if(Input::get('client_id')){

            $criteria['client_id'] = Input::get('client_id');
        }

        //get class name
        if(Input::get('name')){

            $criteria['name'] = Input::get('name');
        }

        //get class grade
        if(Input::get('grade_id')){

            $criteria['grade_id'] = Input::get('grade_id');
        }

        //get order no.
        if(Input::get('order_no')){

            $criteria['order_no'] = Input::get('order_no');
        }

        //get payment status.
        if(Input::get('payment_status')){

           $criteria['payment_status'] = Input::get('payment_status');
        }

        $limit = (Input::get('limit')) ? Input::get('limit') : 0;

        $offset = (Input::get('offset')) ? Input::get('offset') : 0;


        return $this->respondWithData($this->classroom->getClassrooms($criteria,$limit,$offset));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(ClassroomRequest $request)
    {
        $classroom = $request->only([
            'order_no',
            'name',
            'grade_id',
            'client_id',
            'subject_id',
            'seats_taken',
            'seats_total',
            'status'
        ]);
        $classroom = $this->classroom->addClassroom($classroom);

        return $this->respondWithData($classroom);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return $this->respondWithData($this->classroom->getClassroom($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, ClassroomRequest $request)
    {
		//get classroom data
		$classroom = $this->classroom->getClassroom($id);

        //KH# 603: User can edit classroom in an invoice.
        switch($request->route()->getName()){
            case "api.v1.classroom.update":
                $input = $request->only('name');
                break;
            default:
                $input = $request->all();
				$data['subject_id'] = $input['subject_id'];

				//get related classroom via order_no
				$related_classes = $this->classroom->getClassroomByOrderNo($classroom['order_no']);

				if($related_classes){

					foreach($related_classes as $k => $v){

						//update subject_id of classrooms with the same order_no
						$this->classroom->updateClassroom($v['id'], $data);

					}

				}
				break;
        }
        return $this->respondWithData($this->classroom->updateClassroom($id,$input));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        return $this->respondWithData($this->classroom->deleteClassroom($id));
    }

    /**
     *  Delete classrooms by order no.
     *  @param $order_no
     *  @return boolean
     */

    public function deleteClassroomByOrderNo($order_no){
        return $this->respondWithData($this->classroom->deleteClassroomByOrderNo($order_no));
    }
}
