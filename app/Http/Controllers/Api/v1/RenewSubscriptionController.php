<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Core\OrderDetail;
use FutureEd\Models\Repository\ClientDiscount\ClientDiscountRepository;
use Illuminate\Http\Request;
use FutureEd\Http\Requests\Api\RenewSubscriptionRequest;
use FutureEd\Models\Repository\Invoice\InvoiceRepositoryInterface;
use FutureEd\Models\Repository\ClientDiscount\ClientDiscountRepositoryInterface;
use FutureEd\Models\Repository\Order\OrderRepositoryInterface;
use FutureEd\Models\Repository\InvoiceDetail\InvoiceDetailRepositoryInterface;
use FutureEd\Services\InvoiceServices;
use FutureEd\Models\Repository\OrderDetail\OrderDetailRepositoryInterface;
use FutureEd\Models\Repository\Classroom\ClassroomRepositoryInterface;
use FutureEd\Models\Repository\ClassStudent\ClassStudentRepositoryInterface;

class RenewSubscriptionController extends ApiController {

	protected $invoice;
	protected $discount;
	protected $order;
	protected $invoice_detail;
	protected $invoice_service;
	protected $order_detail;
	protected $classroom;
	protected $class_student;


	public function __construct(

		InvoiceRepositoryInterface $invoice,
		ClientDiscountRepositoryInterface $discount,
		OrderRepositoryInterface $order,
		InvoiceDetailRepositoryInterface $invoice_detail,
		InvoiceServices $invoice_service,
		OrderDetailRepositoryInterface $order_detail,
		ClassroomRepositoryInterface $classroom,
		ClassStudentRepositoryInterface $class_student

	){
		$this->invoice = $invoice;
		$this->discount = $discount;
		$this->order = $order;
		$this->invoice_detail = $invoice_detail;
		$this->invoice_service = $invoice_service;
		$this->order_detail = $order_detail;
		$this->classroom = $classroom;
		$this->class_student = $class_student;
	}

	/**
	 * Show the form for creating a new resource.
	 * NOTE id = order_id
	 * @return Response
	 */
	public function renewSubscription($id)
	{

		// $data = $request->only('date_start','date_end','order_date','total_amount','discount');
			// date_start, date_end, discount are not used
			// order_date should be set on payment
			// set total amount to zero, since we have to verify the subscription and discount

		//get invoice details
		$invoice = $this->invoice->getInvoice($id);

		$data['client_id'] = $invoice['client_id'];
		$data['client_name'] = $invoice['client_name'];
		$data['student_id'] = $invoice['student_id'];
		$data['student_name'] = $invoice['student_name'];
		$data['seats_total'] = $invoice['seats_total'];
		$data['discount_type'] = $invoice['discount_type'];
		$data['discount_id'] = $invoice['discount_id'];
		$data['subscription_id'] = $invoice['subscription_id'];
		$data['payment_status'] = config('futureed.pending');
		$data['seats_taken'] = $invoice['order']['seats_taken'];
		$data['total_amount'] = 0;


		//get the last inputted order
		$prev_order = $this->order->getNextOrderNo();

		if(!$prev_order){

			$next_order_id = 1;
		}else{

			$next_order_id = ++$prev_order['id'];
		}

		$id = ($invoice['student_id']==NULL ? $invoice['client_id'] : $invoice['student_id']);

		$data['order_no'] = $this->invoice_service->createOrderNo($id,$next_order_id);


		//add order
		$added_order = $this->order->addOrder($data);

		//get order_detail
		$order_detail = $this->order_detail->getOrderDetailsByOrderId($invoice['order']['id']);

		//add order_detail
		if($order_detail){

			foreach($order_detail as $k => $v){

				$value['order_id'] = $added_order['id'];
				$value['student_id'] = $order_detail[$k]['student_id'];
				$value['price'] = $data['total_amount'];

				$this->order_detail->addOrderDetail($value);
			}
		}

		//add invoice
		// $data['invoice_date'] = $data['order_date'];
		$added_invoice = $this->invoice->addInvoice($data);

		$invoice_detail = $invoice['InvoiceDetail'];

		//add invoice_detail
		if($invoice_detail){

			foreach($invoice_detail as $k => $v){

				//Change classroom first before invoice details
				$classroom = $this->classroom->getClassroom($invoice_detail[$k]['class_id']);

				$classroom->order_no = $data['order_no'];

				$classroom = $this->classroom->addClassroom($classroom->toArray());

				//Transfer Students
				$class_student = $this->class_student->getClassStudentByClassId($invoice_detail[$k]['class_id']);

				foreach($class_student as $key => $stud){

					$stud->class_id = $classroom->id;

					$this->class_student->addClassStudent($stud->toArray());
				}


				//Change invoice details
				$value['invoice_id'] = $added_invoice['id'];
				$value['class_id'] = $classroom->id;
				$value['grade_id'] = $invoice_detail[$k]['grade_id'];
				$value['price'] = $data['total_amount'];
				$this->invoice_detail->addInvoiceDetail($value);
			}

		}

		return $this->respondWithData($this->invoice->getInvoice($added_invoice['id']));


	}



}
