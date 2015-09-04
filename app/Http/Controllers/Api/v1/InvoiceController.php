<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Http\Requests\Api\InvoiceRequest;

use FutureEd\Models\Repository\OrderDetail\OrderDetailRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use FutureEd\Models\Repository\Invoice\InvoiceRepositoryInterface;
use FutureEd\Models\Repository\InvoiceDetail\InvoiceDetailRepositoryInterface;
use FutureEd\Models\Repository\Classroom\ClassroomRepositoryInterface;
use FutureEd\Models\Repository\Order\OrderRepositoryInterface;

use FutureEd\Services\InvoiceServices;

class InvoiceController extends ApiController {

    protected $classrooms;
    protected $invoice;
    protected $invoice_detail;
    protected $invoice_service;
    protected $order;
    protected $order_detail;

    public function __construct(ClassroomRepositoryInterface $classroom,
                                InvoiceRepositoryInterface $invoice,
                                InvoiceDetailRepositoryInterface $invoice_detail,
                                InvoiceServices $invoice_service,
                                OrderRepositoryInterface $order,
                                OrderDetailRepositoryInterface $order_detail){
        $this->classrooms = $classroom;
        $this->invoice = $invoice;
        $this->invoice_detail = $invoice_detail;
        $this->invoice_service = $invoice_service;
        $this->order = $order;
        $this->order_detail = $order_detail;
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

        if(Input::get('subscription_name')){

            $criteria['subscription_name'] = Input::get('subscription_name');
        }

        if(Input::get('payment_status')){

            $criteria['payment_status'] = Input::get('payment_status');

        }
        if(Input::get('client_id')){

            $criteria['client_id'] = Input::get('client_id');

        }

        if(Input::get('student_id')){

            $criteria['student_id'] = Input::get('student_id');

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
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(InvoiceRequest $request)
    {
        $input = $request->all();
        $invoice = $this->invoice->addInvoice($input);

        return $this->respondWithData($invoice);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $invoice = $this->invoice->getInvoice($id);
        return $this->respondWithData($invoice);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id,InvoiceRequest $request)
    {
        // insert invoice here.
        $input = $request->all();
        $invoice = $this->invoice->updateInvoice($id,$input);

        //insert order here.
        $order_input = $request->only('order_no','client_id','subscription_id','date_start','date_end','seats_total','total_amount','payment_status');
        $order_input['order_date'] = $input['invoice_date'];
        $order_input['seats_taken'] = 0;

        $order = $this->order->getOrderByOrderNo($order_input['order_no']);

        if( !is_null($order) ){
            $this->order->updateOrder($order['id'],$order_input);
        }else{
            $this->order->addOrder($order_input);
        }

        //get classrooms to create invoice details.
        $criteria['order_no'] = $input['order_no'];
        $classrooms = $this->classrooms->getClassrooms($criteria,0,0);

        //add invoice details.
        if($classrooms['total'] > 0)
        {
            $class_records = $classrooms['record']->toArray();
            for($i = 0; $i < $classrooms['total']; $i++)
            {
                $result = $this->invoice_detail->getInvoiceDetailByInvoiceIdAndClassId($id,$class_records[$i]['id']);
                if(is_null($result)) {
                    $order_detail['invoice_id'] = $id;
                    $order_detail['class_id'] = $class_records[$i]['id'];
                    $order_detail['grade_id'] = $class_records[$i]['grade_id'];
                    $order_detail['price'] = $order_input['total_amount'];

                    $this->invoice_detail->addInvoiceDetail($order_detail);
                }
            }
        }

        return $this->respondWithData($invoice);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $invoice = $this->invoice->getInvoice($id);

        if(!is_null($invoice)){
            //delete invoice
            $this->invoice->deleteInvoice($id);

            //delete order.
            $order = $this->order->getOrderByOrderNo($invoice->order_no);
            $this->order->deleteOrder($order['id']);

            //delete class.
            $this->classrooms->deleteClassroomByOrderNo($invoice->order_no);

            //delete invoice details
            $this->invoice_detail->deleteInvoiceDetailByInvoiceId($id);

            //delete order detail.
            $this->order_detail->deleteOrderDetailByOrderId($order['id']);
        }

        return $this->respondWithData($invoice);
    }

    /**
     *  Get client discount to be used when adding invoice.
     *  @param $client_id int
     * @return object
     */
    public function getClientInvoiceDiscount($client_id){
        return $this->respondWithData($this->invoice->getClientInvoiceDiscount($client_id));
    }

    public function getNextInvoiceNo($client_id)
    {
        $invoice_no = $this->invoice->getNextInvoiceNo();
        $new_invoice_no = $invoice_no['id'] + 1;
        return $this->respondWithData($this->invoice_service->createInvoiceNo($new_invoice_no));
    }

    public function cancelInvoice($id){
        $invoice = $this->invoice->getInvoice($id);
        if(!is_null($invoice)){

            $data['payment_status'] = config('futureed.cancelled');
            $this->invoice->updateInvoice($id,$data);

            $order_id = $this->order->getOrderByOrderNo($invoice->order_no);
            $order_id = $order_id['id'];
            $this->order->updateOrder($order_id,$data);
        }
        return $this->respondWithData($invoice);
    }
}
