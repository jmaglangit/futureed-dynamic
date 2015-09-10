<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use FutureEd\Http\Requests\Api\StudentPaymentRequest;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Services\InvoiceServices;
use FutureEd\Models\Repository\Order\OrderRepositoryInterface;
use FutureEd\Models\Repository\OrderDetail\OrderDetailRepositoryInterface;
use FutureEd\Models\Repository\Invoice\InvoiceRepositoryInterface;
use FutureEd\Models\Repository\Classroom\ClassroomRepositoryInterface;
use FutureEd\Models\Repository\ClassStudent\ClassStudentRepositoryInterface;
use FutureEd\Models\Repository\InvoiceDetail\InvoiceDetailRepositoryInterface;
use Carbon\Carbon;

use Illuminate\Http\Request;

class StudentPaymentController extends ApiController {

	protected $student;
	protected $invoice_services;
	protected $order;
	protected $order_detail;
	protected $invoice;
	protected $classroom;
	protected $class_student;
	protected $invoice_detail;

	public function __construct(
							StudentRepositoryInterface $student,
							InvoiceServices	$invoice_services,
							OrderRepositoryInterface $order,
							OrderDetailRepositoryInterface $order_detail,
							InvoiceRepositoryInterface $invoice,
							ClassroomRepositoryInterface $classroom,
							ClassStudentRepositoryInterface $class_student,
							InvoiceDetailRepositoryInterface $invoice_detail
								){

		$this->student = $student;
		$this->invoice_services = $invoice_services;
		$this->order = $order;
		$this->order_detail = $order_detail;
		$this->invoice = $invoice;
		$this->classroom = $classroom;
		$this->class_student = $class_student;
		$this->invoice_detail = $invoice_detail;

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function studentPayment(StudentPaymentRequest $request)
	{

		$order = $request->only('subject_id', 'order_date','student_id', 'subscription_id', 'date_start',
								'date_end', 'seats_total', 'seats_taken', 'total_amount', 'payment_status');

		//get student details
		$student = $this->student->viewStudent($order['student_id']);

		//check if student have existing subscription to a subject
		$student_classroom = $this->classroom->getClassroomBySubjectId($order['subject_id'],$order['student_id']);

		if ($student_classroom) {

			return $this->respondErrorMessage(2037);
		}
		//get the last inputted order
		$prev_order = $this->order->getNextOrderNo();

		if(!$prev_order){

			$next_order_id = 1;
		}else{

			$next_order_id = ++$prev_order['id'];
		}

		$order['order_no'] = $this->invoice_services->createOrderNo($order['student_id'],$next_order_id);

		//insert data into order
		$inserted_order = $this->order->addOrder($order);

		//form data for order_details
		$order_detail['order_id'] = $inserted_order['id'];
		$order_detail['student_id'] = $order['student_id'];
		$order_detail['price'] = $order['total_amount'];

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

		return $this->respondWithData($this->order->getOrder($inserted_order['id']));

	}

	public function studentPaymentEdit($id,StudentPaymentRequest $request){


		$order = $request->only('subject_id', 'order_date','student_id', 'subscription_id', 'date_start',
			'date_end', 'seats_total', 'seats_taken', 'total_amount', 'payment_status');

		//get order details
		$order_record = $this->order->getOrder($id);

		//check if student have existing subscription to a subject
		$student_classroom = $this->classroom->getClassroomBySubjectId($order['subject_id'],$order['student_id']);

		if ($student_classroom && $order_record['order_no']!= $student_classroom[0]['order_no']) {

			return $this->respondErrorMessage(2037);
		}

		//get student details
		$student = $this->student->viewStudent($order['student_id']);
		//insert data into order
		$this->order->updateOrder($id,$order);

		//get order_details details
		$order_detail_record = $this->order_detail->getOrderDetailsByOrderId($id);

		//form data for order_details
		$order_detail['student_id'] = $order['student_id'];
		$order_detail['price'] = $order['total_amount'];

		//insert data to order_details table
		$this->order_detail->updateOrderDetail($order_detail_record[0]['id'],$order_detail);

		//get invoice details
		$invoice_record = $this->invoice->getInvoiceByOrderNo($order_record['order_no']);

		//form data for invoice
		$invoice['invoice_date'] = $order['order_date'];
		$invoice['student_id'] = $order['student_id'];
		$invoice['student_name'] = $student['user']['name'];
		$invoice['date_start'] = $order['date_start'];
		$invoice['date_end'] = $order['date_end'];
		$invoice['seats_total'] = $order['seats_total'];
		$invoice['total_amount'] = $order['total_amount'];
		$invoice['subscription_id'] = $order['subscription_id'];
		$invoice['payment_status'] = $order['payment_status'];

		//insert data to invoices table
		$this->invoice->updateInvoice($invoice_record[0]['id'],$invoice);

		//get classroom details
		$classroom_record = $this->classroom->getClassroomByOrderNo($order_record['order_no']);

		//form data for classroom
		$classroom['name'] = config('futureed.STU').Carbon::now()->timestamp;
		$classroom['student_id'] = $order['student_id'];
		$classroom['subject_id'] = $order['subject_id'];
		$classroom['seats_taken'] = $order['seats_taken'];
		$classroom['seats_total'] = $order['seats_total'];

		//insert data to update table
		$this->classroom->updateClassroom($classroom_record[0]['id'],$classroom);

		//get class_student details
		$class_student_record = $this->class_student->getClassStudentByClassId($classroom_record[0]['id']);

		//form data for class_students
		$class_student['student_id'] = $order['student_id'];
		$class_student['date_started'] = $order['order_date'];
		$class_student['subscription_status'] = config('futureed.active');

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
