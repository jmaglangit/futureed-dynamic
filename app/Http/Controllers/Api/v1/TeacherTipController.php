<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use FutureEd\Http\Requests\Api\TeacherTipRequest;
use FutureEd\Models\Repository\Tip\TipRepositoryInterface;

use Illuminate\Http\Request;

class TeacherTipController extends ApiController {

	protected $tip;

	public function __construct(TipRepositoryInterface $tip){

		$this->tip = $tip;
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

		//for created
		if(Input::get('created')){

			$criteria['created'] = Input::get('created');
		}

		//for title
		if(Input::get('title')){

			$criteria['title'] = Input::get('title');
		}

		//for tip_status
		if(Input::get('status')){

			$criteria['status'] = Input::get('status');
		}

		//for area
		if(Input::get('area')){

			$criteria['area'] = Input::get('area');
		}

		//for subject
		if(Input::get('subject')){

			$criteria['subject'] = Input::get('subject');
		}

		if(Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}

		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}

		return $this->respondWithData($this->tip->viewClassTips($criteria , $limit, $offset ));
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

		return $this->respondWithData($tip);


	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id,TeacherTipRequest $request)
	{
		$data = $request->only('title','content');

		//get tip
		$tip = $this->tip->viewTip($id);

		//check if tip is empty
		if(!$tip){

			return $this->respondErrorMessage(2120);
		}

		$this->tip->updateTip($id,$data);

		return $this->respondWithData($this->tip->viewTip($id));

	}

}
