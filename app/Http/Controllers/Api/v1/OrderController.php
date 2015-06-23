<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\OrderRequest;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Order\OrderRepositoryInterface;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use FutureEd\Services\InvoiceServices;

class OrderController extends ApiController {

    protected $invoice_service;
    protected $order;

    public function __construct(OrderRepositoryInterface $order,
                                InvoiceServices $invoice_service){
        $this->order = $order;
        $this->invoice_service = $invoice_service;
    }
    
    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public function index()
    {
        
    }

    /**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */

    public function store(OrderRequest $request)
    {
        $input = $request->all();
        
        $order = $this->order->addOrder($input);
        return $this->respondWithData($order);
    }

    public function getNextOrderNo($client_id)
    {
        $order_no = $this->order->getNextOrderNo();
        $new_order_no = $order_no['id'] + 1;
        return $this->respondWithData($this->invoice_service->createOrderNo($client_id,$new_order_no));
    }
}
