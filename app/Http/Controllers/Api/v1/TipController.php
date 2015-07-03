<?php namespace FutureEd\Http\Controllers\api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Http\Requests\Api\TipRequest;
use FutureEd\Models\Repository\Tip\TipRepositoryInterface;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;

class TipController extends ApiController {

	protected $tip;

	public function __construct(TipRepositoryInterface $tip){

		$this->tip = $tip;
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 * this will  update the tip_status if verified|rejected
	 */
	public function updateTipStatus($id, TipRequest $request)
	{
		$data = $request->only('tip_status');

		//view tip details

		$tip = $this->tip->viewTip($id);

		if(!$tip){

			return $this->respondErrorMessage(2120);
		}

		$this->tip->updateTip($id,$data);

		return $this->respondWithData($this->tip->viewTip($id));

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 * this is for student only
	 * view first 3 most recent general tips under a class
	 */

	public function viewCurrentTips(){

		$class_id = NULL;

		//get class_id
		if(Input::get('class_id')){

			$class_id= Input::get('class_id');
		}

		$tip = $this->tip->viewCurrentTips($class_id);

		return $this->respondWithData($tip);

	}






}
