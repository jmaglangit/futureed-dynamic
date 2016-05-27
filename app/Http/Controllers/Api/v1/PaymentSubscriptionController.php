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



}
