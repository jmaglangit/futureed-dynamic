<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\OrderRequest;
use FutureEd\Models\Repository\Order\OrderRepositoryInterface;
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

    /**
     * Create stub record for order.
     * @param $client_id
     * @return newly created order record.
     */
    public function getNextOrderNo($client_id)
    {
        $input['client_id'] = $client_id;
        $input['payment_status'] = 'Pending';
        $order = $this->order->addOrder($input);

        $order['order_no'] = $this->invoice_service->createOrderNo($client_id,$order['id']);
        $this->order->updateOrder($order['id'],$order);

        return $this->respondWithData($order);
    }

    /**
     * Get order.
     * @param $id
     * @return mixed
     */
    public function show($id){

        return $this->respondWithData($this->order->getOrder($id));
    }

    /**
     * Update Order start and end dates.
     * @param $id
     * @param OrderRequest $request
     * @return mixed
     */
    public function update($id, OrderRequest $request){

        $order = $request->all();

        $this->order->updateOrder($id,$order);

        return $this->order->getOrder($id);

    }
}
