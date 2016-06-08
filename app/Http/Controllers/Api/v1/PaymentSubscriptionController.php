<?php namespace FutureEd\Http\Controllers\Api\v1;

use Carbon\Carbon;
use FutureEd\Http\Requests;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
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
	protected $client;


	public function __construct(

		InvoiceRepositoryInterface $invoice,
		ClientDiscountRepositoryInterface $discount,
		OrderRepositoryInterface $order,
		InvoiceDetailRepositoryInterface $invoice_detail,
		InvoiceServices $invoice_service,
		OrderDetailRepositoryInterface $order_detail,
		ClassroomRepositoryInterface $classroom,
		ClassStudentRepositoryInterface $class_student,
		StudentRepositoryInterface $studentRepositoryInterface,
		ClientRepositoryInterface $clientRepositoryInterface

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
		$this->client = $clientRepositoryInterface;
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

		$data = [
			'order_no' => $invoice['order_no'],
			'invoice_date' => Carbon::now()->toDateString(),
			'client_id' => $invoice['client_id'],
			'client_name' => $invoice['client_name'],
			'student_id' => $invoice['student_id'],
			'student_name' =>  $invoice['student_name'],
			'date_start' => Carbon::now()->toDateString(),
			'date_end' => Carbon::now()
				->addDays($invoice->subscriptionPackage->subscription_day->days)->toDateString(),
			'seats_total' => $invoice['seats_total'],
			'discount_type' => $invoice['discount_type'],
			'discount_id' => $invoice['discount_id'],
			'discount' => $invoice['discount'],
			'total_amount' => $invoice['total_amount'],
			'subscription_id' => $invoice['subscription_id'],
			'subscription_package_id' => $invoice['subscription_package_id'],
			'renew' => config('futureed.true'),
			'payment_status' => config('futureed.pending'),
			'seats_taken' => $invoice['order']['seats_taken']
		];

		//add invoice
		$added_invoice = $this->invoice->addInvoice($data);

		$invoice_detail = $invoice->invoiceDetail;

		//add invoice_detail
		if($invoice_detail){

			foreach($invoice_detail as $k => $v){

				//Change invoice details
				$value = [
					'invoice_id' => $added_invoice['id'],
					'class_id' => $v->class_id,
					'grade_id' => $v->grade_id,
					'price' => $data['total_amount']
				];

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
		$prev_order = $this->order->getLastOrderNo();

		if(!$prev_order){

			$next_order_id = 1;
		}else{

			$next_order_id = ++$prev_order['id'];
		}

		$order['order_no'] = $this->invoice_service->createOrderNo($order['student_id'],$next_order_id);

		//insert data into order
		$inserted_order = $this->order->addOrder($order);

		//form data for order_details
		$order_detail = [
			'order_id' => $inserted_order['id'],
			'student_id' => $order['student_id'],
			'price' => $order['sub_total']
		];

		//insert data to order_details table
		$this->order_detail->addOrderDetail($order_detail);

		//form data for invoice
		$invoice = [
			'order_no' => $order['order_no'],
			'invoice_date' => $order['order_date'],
			'student_id' => $order['student_id'],
			'student_name' => $student['user']['name'],
			'date_start' => $order['date_start'],
			'date_end' => $order['date_end'],
			'seats_total' => $order['seats_total'],
			'total_amount' => $order['total_amount'],
			'subscription_id' => $order['subscription_id'],
			'payment_status' => $order['payment_status'],
			'subscription_package_id' => $order['subscription_package_id'],
			'discount_id' => $order['discount_id'],
			'discount' => $order['discount']
		];

		//insert data to invoices table
		$inserted_invoice = $this->invoice->addInvoice($invoice);

		//form data for classroom
		$classroom = [
			'order_no' => $order['order_no'],
			'name' => config('futureed.STU').Carbon::now()->timestamp,
			'grade_id' => $student['grade']['id'],
			'student_id' => $order['student_id'],
			'subject_id' => $order['subject_id'],
			'seats_taken' => $order['seats_taken'],
			'seats_total' => $order['seats_total']
		];

		//insert data to classrooms table
		$inserted_classroom = $this->classroom->addClassroom($classroom);

		//form data for class_students
		$class_student = [
			'student_id' => $order['student_id'],
			'class_id' => $inserted_classroom['id'],
			'date_started' => $order['order_date'],
			'subscription_status' => config('futureed.active')
		];

		//insert data to class_students table
		$this->class_student->addClassStudent($class_student);

		//form data for invoice detail
		$invoice_detail = [
			'invoice_id' => $inserted_invoice['id'],
			'class_id' => $inserted_classroom['id'],
			'grade_id' => $student['grade']['id'],
			'price' => $order['total_amount']
		];

		//insert data to invoice_detail
		$this->invoice_detail->addInvoiceDetail($invoice_detail);

		return $this->respondWithData($invoice);
	}

	/**
	 * Add payment by principal.
	 *
	 * @param PaymentSubscriptionRequest $request
	 * @return mixed
	 * @internal param $id
	 */
	public function paySubscription(PaymentSubscriptionRequest $request)
	{
		/**
		 * TODO
		 * 1. create order
		 * 2. create order details
		 * 3. create invoice
		 * 4. create invoice details
		 * 5. classroom
		 */

		$order = $request->all();

		//create order
		$prev_order = $this->order->getLastOrderNo();

		if(!$prev_order){

			$next_order_id = 1;
		}else{

			$next_order_id = ++$prev_order['id'];
		}

		$order['order_no'] = $this->invoice_service->createOrderNo($order['client_id'],$next_order_id);

		$new_order = $this->order->addOrder($order);

		$client = $this->client->getClientDetails($order['client_id']);

		//create invoice
		$invoice = [
			'order_no' => $order['order_no'],
			'invoice_date' => $order['order_date'],
			'client_id' => $order['client_id'],
			'client_name' => $client->user->name,
			'date_start' => $order['date_start'],
			'date_end' => $order['date_end'],
			'seats_total' => $order['seats_total'],
			'total_amount' => $order['total_amount'],
			'subscription_id' => $order['subscription_id'],
			'payment_status' => $order['payment_status'],
			'subscription_package_id' =>  $order['subscription_package_id'],
			'discount_id' => isset($order['discount_id']) ? $order['discount_id'] : 0,
			'discount' => isset($order['discount']) ? $order['discount'] : 0
		];

		//insert data to invoices table
		$inserted_invoice = $this->invoice->addInvoice($invoice);

		//insert new classroom
		foreach($order['classrooms'] as $class){

			$classroom = [
				'order_no' => $order['order_no'],
				'name' => $class['class_name'],
				'grade_id' => $class['grade']['id'],
				'client_id' => $class['teacher']['id'],
				'subject_id' => $order['subject_id'],
				'seats_taken' => config('futureed.false'),
				'seats_total' => $class['seats']
			];

			//insert data to classrooms table
			$inserted_classroom = $this->classroom->addClassroom($classroom);

			//insert invoice details
			//form data for invoice detail
			$invoice_detail = [
				'invoice_id' => $inserted_invoice['id'],
				'class_id' => $inserted_classroom['id'],
				'grade_id' => $class['grade']['id'],
				'price' => $class['price']
			];


			//insert data to invoice_detail
			$this->invoice_detail->addInvoiceDetail($invoice_detail);
		}

		return $this->respondWithData($inserted_invoice);
	}


}
