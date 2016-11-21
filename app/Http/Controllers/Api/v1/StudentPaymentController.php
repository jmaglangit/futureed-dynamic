<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\StudentPaymentRequest;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\SubscriptionPackage\SubscriptionPackageRepositoryInterface;
use FutureEd\Services\InvoiceServices;
use FutureEd\Models\Repository\Order\OrderRepositoryInterface;
use FutureEd\Models\Repository\OrderDetail\OrderDetailRepositoryInterface;
use FutureEd\Models\Repository\Invoice\InvoiceRepositoryInterface;
use FutureEd\Models\Repository\Classroom\ClassroomRepositoryInterface;
use FutureEd\Models\Repository\ClassStudent\ClassStudentRepositoryInterface;
use FutureEd\Models\Repository\InvoiceDetail\InvoiceDetailRepositoryInterface;
use Carbon\Carbon;
use FutureEd\Services\SubscriptionServices;
use FutureEd\Services\UserServices;

class StudentPaymentController extends ApiController {

	protected $student;
	protected $invoice_services;
	protected $order;
	protected $order_detail;
	protected $invoice;
	protected $classroom;
	protected $class_student;
	protected $invoice_detail;
	protected $subscription_service;
	protected $subscription_package;
	protected $user_service;

	/**
	 * @param StudentRepositoryInterface $student
	 * @param InvoiceServices $invoice_services
	 * @param OrderRepositoryInterface $order
	 * @param OrderDetailRepositoryInterface $order_detail
	 * @param InvoiceRepositoryInterface $invoice
	 * @param ClassroomRepositoryInterface $classroom
	 * @param ClassStudentRepositoryInterface $class_student
	 * @param InvoiceDetailRepositoryInterface $invoice_detail
	 * @param SubscriptionServices $subscriptionServices
	 * @param SubscriptionPackageRepositoryInterface $subscriptionPackageRepositoryInterface
	 * @param UserServices $userServices
	 */
	public function __construct(
							StudentRepositoryInterface $student,
							InvoiceServices	$invoice_services,
							OrderRepositoryInterface $order,
							OrderDetailRepositoryInterface $order_detail,
							InvoiceRepositoryInterface $invoice,
							ClassroomRepositoryInterface $classroom,
							ClassStudentRepositoryInterface $class_student,
							InvoiceDetailRepositoryInterface $invoice_detail,
							SubscriptionServices $subscriptionServices,
							SubscriptionPackageRepositoryInterface $subscriptionPackageRepositoryInterface,
							UserServices $userServices
								){

		$this->student = $student;
		$this->invoice_services = $invoice_services;
		$this->order = $order;
		$this->order_detail = $order_detail;
		$this->invoice = $invoice;
		$this->classroom = $classroom;
		$this->class_student = $class_student;
		$this->invoice_detail = $invoice_detail;
		$this->subscription_service = $subscriptionServices;
		$this->subscription_package = $subscriptionPackageRepositoryInterface;
		$this->user_service = $userServices;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param StudentPaymentRequest $request
	 * @return Response
	 */
	public function studentPayment(StudentPaymentRequest $request)
	{

		$order = $request->only('subject_id', 'order_date','student_id', 'subscription_id',
								'date_end', 'seats_total', 'seats_taken', 'total_amount', 'payment_status',
								'subscription_package_id','discount_id','discount','sub_total');

		//get student details
		$student = $this->student->viewStudent($order['student_id']);

		//check if student have existing subscription to a subject
		$student_classroom = $this->classroom->getClassroomBySubjectId($order['subject_id'],$order['student_id']);

		if ($student_classroom
			&& $student->user->curriculum_country == $student_classroom[0]['invoice']['subscription_package']['country_id'] 
				&& $student_classroom[0]['invoice']['payment_status'] != config('futureed.cancelled')) {

			return $this->respondErrorMessage(2037);
		}
		//get the last inputted order
		$prev_order = $this->order->getLastOrderNo();

		if(!$prev_order){

			$next_order_id = 1;
		}else{

			$next_order_id = ++$prev_order['id'];
		}

		$num_of_days = $order['date_end'];
		$now = Carbon::now();

		$order['date_start'] = $now->toDateTimeString();
		$order['date_end'] = $now->addDays($num_of_days)->toDateTimeString();
		$order['payment_status'] = $this->subscription_service->checkPriceValue($order['total_amount']);
		$order['order_no'] = $this->invoice_services->createOrderNo($order['student_id'],$next_order_id);

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
			'discount_id' => (isset($order['discount_id']))? $order['discount_id'] : 0,
			'discount' => $order['discount']
		];

		//insert data to invoices table
		$inserted_invoice = $this->invoice->addInvoice($invoice);

		//form data for classroom
		$classroom = [
			'order_no' => $order['order_no'],
			'name' => config('futureed.STU') . Carbon::now()->timestamp,
			'grade_id' => ($student['grade']) ? $student['grade']['id'] : config('futureed.false'),
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
			'invoice_id' => (isset($inserted_invoice['id'])) ? $inserted_invoice['id'] : 0 ,
			'class_id' => $inserted_classroom['id'],
			'grade_id' => ($student['grade']) ? $student['grade']['id'] : config('futureed.false'),
			'price' => $order['total_amount']
		];

		//insert data to invoice_detail
		$this->invoice_detail->addInvoiceDetail($invoice_detail);

		//get country on subscription package
		$subscription = $this->subscription_package->getSubscriptionPackage($order['subscription_package_id']);

		//updated user curr id
		$this->user_service->updateCurriculumCountry($student->user_id,$subscription->country_id);

		return $this->respondWithData($this->order->getOrder($inserted_order['id']));

	}

	/**
	 * @param $id
	 * @param StudentPaymentRequest $request
	 * @return mixed
	 */
	public function studentPaymentEdit($id,StudentPaymentRequest $request){

		$order = $request->only('subject_id', 'order_date','student_id', 'subscription_id', 'date_start',
			'date_end', 'seats_total', 'seats_taken', 'total_amount', 'payment_status','discount_id');

		//get order details
		$order_record = $this->order->getOrder($id);

		//check if student have existing subscription to a subject
		$student_classroom = $this->classroom->getClassroomBySubjectId($order['subject_id'],$order['student_id']);

		//get student details
		$student = $this->student->viewStudent($order['student_id']);

		//check if student have existing subscription to a subject
		$student_classroom = $this->classroom->getClassroomBySubjectId($order['subject_id'],$order['student_id']);

		if ($student_classroom
			&& $order_record['order_no']!= $student_classroom[0]['order_no']
			&& $student->user->curriculum_country == $student_classroom[0]['invoice']['subscription_package']['country_id']
			&& $student_classroom[0]['invoice']['payment_status'] == config('futureed.paid')) {

			return $this->respondErrorMessage(2037);
		}

		$order['payment_status'] = $this->subscription_service->checkPriceValue($order['total_amount']);


		//get student details
		$student = $this->student->viewStudent($order['student_id']);

		//insert data into order
		$this->order->updateOrder($id,$order);

		//get order_details details
		$order_detail_record = $this->order_detail->getOrderDetailsByOrderId($id);

		//form data for order_details
		$order_detail = [
			'student_id' => $order['student_id'],
			'price' => $order['total_amount']
		];

		//insert data to order_details table
		$this->order_detail->updateOrderDetail($order_detail_record[0]['id'],$order_detail);

		//get invoice details
		$invoice_record = $this->invoice->getInvoiceByOrderNo($order_record['order_no'],config('futureed.enabled'));

		//form data for invoice
		$invoice = [
			'invoice_date' => $order['order_date'],
			'student_id' => $order['student_id'],
			'student_name' => $student['user']['name'],
			'date_start' => $order['date_start'],
			'date_end' => $order['date_end'],
			'seats_total' => $order['seats_total'],
			'total_amount' => $order['total_amount'],
			'subscription_id' => $order['subscription_id'],
			'payment_status' => $order['payment_status'],
			'discount_id' => $order['discount_id']
		];

		//insert data to invoices table
		$this->invoice->updateInvoice($invoice_record[0]['id'],$invoice);

		//get classroom details
		$classroom_record = $this->classroom->getClassroomByOrderNo($order_record['order_no']);

		//form data for classroom
		$classroom = [
			'name' => config('futureed.STU') . Carbon::now()->timestamp,
			'student_id' => $order['student_id'],
			'subject_id' => $order['subject_id'],
			'seats_taken' => $order['seats_taken'],
			'seats_total' => $order['seats_total']
		];

		//insert data to update table
		$this->classroom->updateClassroom($classroom_record[0]['id'],$classroom);

		//get class_student details
		$class_student_record = $this->class_student->getClassStudentByClassId($classroom_record[0]['id']);

		//form data for class_students
		$class_student = [
			'student_id' => $order['student_id'],
			'date_started' => $order['order_date'],
			'subscription_status' => config('futureed.active')
		];

		//update class_student
		$this->class_student->updateClassStudent($class_student_record[0]['id'],$class_student);

		//get invoice detail
		$invoice_detail_record = $this->invoice_detail->getInvoiceDetailByInvoiceIdAndClassId($invoice_record[0]['id'],$classroom_record[0]['id']);

		//form data for invoice detail
		$invoice_detail['price'] = $order['total_amount'];

		//update invoice detail
		$this->invoice_detail->updateInvoiceDetail($invoice_detail_record['id'], $invoice_detail);

		return $this->respondWithData($this->order->getOrder($id));
	}

}
