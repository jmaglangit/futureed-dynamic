<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use FutureEd\Models\Repository\ClientDiscount\ClientDiscountRepositoryInterface as ClientDiscount;

use FutureEd\Http\Requests\Api\ClientDiscountRequest;

class ClientDiscountController extends ApiController {

	//holds the client_discount repository
	protected $client_discount;

	/**
	 * ClientDiscount Controller constructor
	 *
	 * @return void
	 */
	public function __construct(ClientDiscount $client_discount) 
	{
		$this->client_discount = $client_discount;
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
			
		if(Input::get('name')) {
			$criteria['name'] = Input::get('name');
		}
		
		if(Input::get('client_role')) {
			$criteria['client_role'] = Input::get('client_role');
		}

		if(Input::get('client_id')) {
			$criteria['client_id'] = Input::get('client_id');
		}
				
		if(Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}
		
		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}
			
		$client_discount = $this->client_discount->getClientDiscounts($criteria, $limit, $offset);

		return $this->respondWithData($client_discount);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ClientDiscountRequest $request)
	{
		$data = $request->all();
	
		$client_discount = $this->client_discount->addClientDiscount($data);
		
		return $this->respondWithData(['id' => $client_discount["id"]]);
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
    		return $this->respondWithData($this->client_discount->getClientDiscount($id));
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id,ClientDiscountRequest $request)
	{
	    if(!is_null($id)){
	    
    	    $data = $request->all();
            return $this->respondWithData($this->client_discount->updateClientDiscount($id,$data));
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
    		return $this->respondWithData($this->client_discount->deleteClientDiscount($id));
		}
	}

}
