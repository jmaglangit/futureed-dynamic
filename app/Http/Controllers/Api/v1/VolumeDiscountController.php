<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use FutureEd\Models\Repository\VolumeDiscount\VolumeDiscountRepositoryInterface as VolumeDiscount;

use FutureEd\Http\Requests\Api\VolumeDiscountRequest;
use FutureEd\Http\Requests\Api\StatusRequest;

class VolumeDiscountController extends ApiController {

	//holds the volumeDiscount repository
	protected $volume_discount;

	/**
	 * volumeDiscount Controller constructor
	 *
	 * @return void
	 */
	public function __construct(VolumeDiscount $volumeDiscount) 
	{
		$this->volume_discount = $volumeDiscount;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$criteria = array();
		$limit = 0;
		$offset = 0;
			
		if(Input::get('min_seats')) {
			$criteria['min_seats'] = Input::get('min_seats');
		}
				
		if(Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}
		
		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}
			
		$volumeDiscount = $this->volume_discount->getVolumeDiscounts($criteria, $limit, $offset);

		return $this->respondWithData($volumeDiscount);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(VolumeDiscountRequest $request)
	{
		$data = $request->all();
	
		$volumeDiscount = $this->volume_discount->addVolumeDiscount($data);
		
		return $this->respondWithData(['id' => $volumeDiscount["id"]]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		if(!is_null($id)){
    		return $this->respondWithData($this->volume_discount->getVolumeDiscount($id));
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id,VolumeDiscountRequest $request)
	{
	    if(!is_null($id)){
	    
    	    $data = $request->all();
            return $this->respondWithData($this->volume_discount->updateVolumeDiscount($id,$data));
	    }		
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if(!is_null($id)){
    		return $this->respondWithData($this->volume_discount->deleteVolumeDiscount($id));
		}
	}
}
