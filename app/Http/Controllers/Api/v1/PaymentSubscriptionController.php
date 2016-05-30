<?php namespace FutureEd\Http\Controllers\Api\v1;

use Carbon\Carbon;
use FutureEd\Http\Requests;
use FutureEd\Models\Repository\Invoice\InvoiceRepositoryInterface;
use FutureEd\Models\Repository\ClientDiscount\ClientDiscountRepositoryInterface;
use FutureEd\Models\Repository\Order\OrderRepositoryInterface;
use FutureEd\Models\Repository\InvoiceDetail\InvoiceDetailRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Services\InvoiceServices;
use FutureEd\Models\Repository\OrderDetail\OrderDetailRepositoryInterface;
use FutureEd\Models\Repository\Classroom\ClassroomRepositoryInterface;
use FutureEd\Models\Repository\ClassStudent\ClassStudentRepositoryInterface;
use FutureEd\Http\Requests\Api\PaymentSubscriptionRequest;

class PaymentSubscriptionController extends ApiController {

	protected $invoice;
	protected $discount;
	protected $order;
	protected $invoice_detail;
	protected $invoice_service;
	protected $order_detail;
	protected $classroom;
	protected $class_student;
	protected $student;


	public function __construct(

		InvoiceRepositoryInterface $invoice,
		ClientDiscountRepositoryInterface $discount,
		OrderRepositoryInterface $order,
		InvoiceDetailRepositoryInterface $invoice_detail,
		InvoiceServices $invoice_service,
		OrderDetailRepositoryInterface $order_detail,
		ClassroomRepositoryInterface $classroom,
		ClassStudentRepositoryInterface $class_student,
		StudentRepositoryInterface $studentRepositoryInterface

	){
		$this->student = $studentRepositoryInterface;
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
	 * @param $id
	 * @return mixed
	 */
	public function renewSubscription($id)
	{

			// date_start, date_end, discount are not used
			// order_date should be set on payment
			// set total amount to zero, since we have to verify the subscription and discount

		//get invoice details
		$invoice = $this->invoice->getInvoice($id);

		$data['order_no'] = $invoice['order_no'];
		$data['invoice_date'] = Carbon::now()->toDateString();
		$data['client_id'] = $invoice['client_id'];
		$data['client_name'] = $invoice['client_name'];
		$data['student_id'] = $invoice['student_id'];
		$data['student_name'] = $invoice['student_name'];
		$data['date_start'] = Carbon::now()->toDateString();
		$data['date_end'] = Carbon::now()->addDays($invoice->subscriptionPackage->subscription_day->days)->toDateString();
		$data['seats_total'] = $invoice['seats_total'];
		$data['discount_type'] = $invoice['discount_type'];
		$data['discount_id'] = $invoice['discount_id'];
		$data['discount'] = $invoice['discount'];
		$data['total_amount'] = $invoice['total_amount'];
		$data['subscription_id'] = $invoice['subscription_id'];
		$data['subscription_package_id'] = $invoice['subscription_package_id'];
		$data['renew'] = 1;
		$data['payment_status'] = config('futureed.pending');
		$data['seats_taken'] = $invoice['order']['seats_taken'];

		//add invoice
		$added_invoice = $this->invoice->addInvoice($data);

		$invoice_detail = $invoice->invoiceDetail;

		//add invoice_detail
		if($invoice_detail){

			foreach($invoice_detail as $k => $v){

				//Change invoice details
				$value['invoice_id'] = $added_invoice['id'];
				$value['class_id'] = $v->class_id;
				$value['grade_id'] = $v->grade_id;
				$value['price'] = $data['total_amount'];
				$this->invoice_detail->addInvoiceDetail($value);
			}

		}

		//update old purchase
		$this->invoice->updateStatus($id,config('futureed.disabled'));

		return $this->respondWithData($this->invoice->getInvoice($added_invoice['id']));
	}

	/**
	 * @param PaymentSubscriptionRequest $request
	 */
	public function saveSubscription(PaymentSubscriptionRequest $request){

		$order = $request->all();

		//get student details
		$student = $this->student->viewStudent($order['student_id']);

		//get the last inputted order
		$prev_order = $this->order->getNextOrderNo();

		if(!$prev_order){

			$next_order_id = 1;
		}else{

			$next_order_id = ++$prev_order['id'];
		}

		$order['order_no'] = $this->invoice_service->createOrderNo($order['student_id'],$next_order_id);

		//insert data into order
		$inserted_order = $this->order->addOrder($order);

		//form data for order_details
		$order_detail['order_id'] = $inserted_order['id'];
		$order_detail['student_id'] = $order['student_id'];
		$order_detail['price'] = $order['sub_total'];

		//insert data to order_details table
		$this->order_detail->addOrderDetail($order_detail);
		//form data for invoice
		$invoice['order_no'] = $order['order_no'];
		$invoice['invoice_date'] = $order['order_date'];
		$invoice['student_id'] = $order['student_id'];
		$invoice['student_name'] = $student['user']['name'];
		$invoice['date_start'] = $order['date_start'];
		$invoice['date_end'] = $order['date_end'];
		$invoice['seats_total'] = $order['seats_total'];
		$invoice['total_amount'] = $order['total_amount'];
		$invoice['subscription_id'] = $order['subscription_id'];
		$invoice['payment_status'] = $order['payment_status'];
		$invoice['subscription_package_id'] =  $order['subscription_package_id'];
		$invoice['discount_id'] = $order['discount_id'];
		$invoice['discount'] = $order['discount'];

		//insert data to invoices table
		$inserted_invoice = $this->invoice->addInvoice($invoice);

		//form data for classroom
		$classroom['order_no'] = $order['order_no'];
		$classroom['name'] = config('futureed.STU').Carbon::now()->timestamp;
		$classroom['grade_id'] = $student['grade']['id'];
		$classroom['student_id'] = $order['student_id'];
		$classroom['subject_id'] = $order['subject_id'];
		$classroom['seats_taken'] = $order['seats_taken'];
		$classroom['seats_total'] = $order['seats_total'];

		//insert data to classrooms table
		$inserted_classroom = $this->classroom->addClassroom($classroom);

		//form data for class_students
		$class_student['student_id'] = $order['student_id'];
		$class_student['class_id'] = $inserted_classroom['id'];
		$class_student['date_started'] = $order['order_date'];
		$class_student['subscription_status'] = config('futureed.active');

		//insert data to class_students table
		$inserted_class_student = $this->class_student->addClassStudent($class_student);

		//form data for invoice detail
		$invoice_detail['invoice_id'] = $inserted_invoice['id'];
		$invoice_detail['class_id'] = $inserted_classroom['id'];
		$invoice_detail['grade_id'] = $student['grade']['id'];
		$invoice_detail['price'] = $order['total_amount'];

		//insert data to invoice_detail
		$this->invoice_detail->addInvoiceDetail($invoice_detail);

		return $this->respondWithData($invoice);
	}


}
