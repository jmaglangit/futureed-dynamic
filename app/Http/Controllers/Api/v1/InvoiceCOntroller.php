<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Http\Requests\Api\InvoiceRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use FutureEd\Models\Repository\Invoice\InvoiceRepositoryInterface as Invoice;

class InvoiceCOntroller extends ApiController {

    protected $invoice;

    public function __construct(Invoice $invoice){

        $this->invoice = $invoice;
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

        if(Input::get('order_no')) {

            $criteria['order_no'] = Input::get('order_no');

        }

        if(Input::get('subscription_id')){

            $criteria['subscription_id'] = Input::get('subscription_id');
        }

        if(Input::get('payment_status')){

            $criteria['payment_status'] = Input::get('payment_status');

        }

        if(Input::get('limit')) {
            $limit = intval(Input::get('limit'));
        }

        if(Input::get('offset')) {
            $offset = intval(Input::get('offset'));
        }

        $invoice = $this->invoice->getInvoiceDetails($criteria,$limit,$offset);

        return $this->respondWithData($invoice);


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
	 */
	public function store()
	{

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
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
