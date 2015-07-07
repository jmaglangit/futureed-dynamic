<?php namespace FutureEd\Http\Controllers\api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use FutureEd\Http\Requests\Api\StudentTipRequest;
use Illuminate\Support\Facades\Input;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\Tip\TipRepositoryInterface;
use FutureEd\Services\AvatarServices;

class StudentTipController extends ApiController {

	protected $student;
	protected $tip;
	protected $avatar;

	public function __construct(StudentRepositoryInterface $student,TipRepositoryInterface $tip, AvatarServices $avatar){

		$this->student = $student;
		$this->tip = $tip;
		$this->avatar = $avatar;

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$criteria = [];
		$limit = 0 ;
		$offset = 0;

		//for class_id
		if(Input::get('class_id')){

			$criteria['class_id'] = Input::get('class_id');
		}

		//for area
		if(Input::get('area')){

			$criteria['area'] = Input::get('area');
		}

		//for subject
		if(Input::get('subject')){

			$criteria['subject'] = Input::get('subject');
		}

		//assign value to status = Accepted
		$criteria['status'] = config('futureed.tip_status_accepted');

		if(Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}

		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}

		return $this->respondWithData($this->tip->viewClassTips($criteria , $limit, $offset ));

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 * student add tips
	 */
	public function store(StudentTipRequest $request)
	{
		$data = $request->only('title','content','student_id');

		$data['class_id'] = 0;
		$data['link_type'] = config('futureed.link_type_general');

		//get student details with relation to class
		$student = $this->student->viewStudentClassBadge($data['student_id']);

		//check if student is empty
		if(!$student){

			return $this->respondErrorMessage(2001);
		}

		//check if student is associated with class
		if($student['classroom']){

			//get the classroom class_id and save the value to data['class_id'];
			$data['class_id'] = $student['classroom']['class_id'];
		}

		//add data to tips
		$return = $this->tip->addTip($data);

		return $this->respondWithData(['id' => $return['id']]);

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$tip = $this->tip->viewTip($id);

		if(!$tip){

			return $this->respondErrorMessage(2120);
		}

		$tip->student->avatar->avatar_url = $this->avatar->getAvatarUrl($tip->student->avatar->avatar_image);

		return $this->respondWithData($tip);

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
