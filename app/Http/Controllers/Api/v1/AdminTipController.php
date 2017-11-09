<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Http\Requests\Api\AdminTipRequest;
use Illuminate\Support\Facades\Input;
use FutureEd\Models\Repository\Tip\TipRepositoryInterface;


use Illuminate\Http\Request;

class AdminTipController extends ApiController {

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

		//for tip_status
		if(Input::get('status')){

			$criteria['status'] = Input::get('status');
		}

		//for link_type
		if(Input::get('link_type')){

			$criteria['link_type'] = Input::get('link_type');
		}

		//for module
		if(Input::get('module')){

			$criteria['module'] = Input::get('module');
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

		return $this->respondWithData($this->tip->getTips($criteria , $limit, $offset ));




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
	public function update($id,AdminTipRequest $request )
	{
		$data = $request->only('title','content','link_type','status');

		//get tip
		$tip = $this->tip->viewTip($id);

		//check if tip is empty
		if(!$tip){

			return $this->respondErrorMessage(2120);
		}

		$this->tip->updateTip($id,$data);

		return $this->respondWithData($this->tip->viewTip($id));


	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

		$tip = $this->tip->viewTip($id);

		if(!$tip){

			return $this->respondErrorMessage(2120);
		}

		if($tip['rating'] != NULL){

			return $this->respondErrorMessage(2136);
		}

		return $this->respondWithData($this->tip->deleteTip($id));


	}

}
