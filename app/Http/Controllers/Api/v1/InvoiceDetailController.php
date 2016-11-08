<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\InvoiceDetailRequest;

use FutureEd\Models\Repository\InvoiceDetail\InvoiceDetailRepositoryInterface as InvoiceDetail;
use FutureEd\Models\Repository\Classroom\ClassroomRepositoryInterface;
use FutureEd\Models\Repository\Invoice\InvoiceRepositoryInterface;
use FutureEd\Models\Repository\Order\OrderRepositoryInterface;
use FutureEd\Models\Repository\OrderDetail\OrderDetailRepositoryInterface;
use Illuminate\Support\Facades\Input;

class InvoiceDetailController extends ApiController {

	/**
	 * @var InvoiceDetail
	 */
	protected $detail;

	/**
	 * @var InvoiceRepositoryInterface
	 */
	protected $invoice;

	/**
	 * @var OrderRepositoryInterface
	 */
	protected $order;

	/**
	 * @param InvoiceDetail $detail
	 * @param InvoiceRepositoryInterface $invoice
	 * @param OrderRepositoryInterface $orderRepositoryInterface
	 * @param InvoiceServices $classroom
	 */
	public function __construct(
		InvoiceDetail $detail,
		InvoiceRepositoryInterface $invoice,
		OrderRepositoryInterface $orderRepositoryInterface
	)
	{

		$this->detail = $detail;
		$this->invoice = $invoice;
		$this->order = $orderRepositoryInterface;
	}


	/**
	 * @return mixed
	 */
	public function viewInvoiceDetail()
	{

		$id = null;

		if (Input::get('id')) {

			$id = Input::get('id');
		}

		$return = $this->invoice->getInvoice($id);

		if (!$return) {

			return $this->respondErrorMessage(2120);
		}

		$detail = $this->invoice->getDetails($id);

		return $this->respondWithData($detail);

	}


	/**
	 * @param InvoiceDetailRequest $request
	 * @return mixed
	 */
	public function editInvoiceDetails(InvoiceDetailRequest $request)
	{

		$data = $request->only('id', 'payment_status');

		$id = $data['id'];
		$return = $this->invoice->getInvoice($id);

		if (!$return) {

			return $this->respondErrorMessage(2120);
		}


		if ($data['payment_status'] == config('futureed.paid')) {

			$criteria =array('student_id' => $return['student_id'], 'payment_status' => config('futureed.paid'));

			$subject_id = $return['invoiceDetail'][0]['classroom']['subject_id'];

			$result = $this->invoice->getInvoiceDetails($criteria ,0 ,0 );

			if ($this->invoiceService->compareInvoice($result, $subject_id, $id)) {

					return $this->respondErrorMessage(2037);

			}
		}

		//update invoice
		$this->invoice->updateInvoice($id, $data);

		//update order payment_status
		$invoice = $this->invoice->getInvoice($id);

		$this->order->updateOrderPaymentStatusByOrderNo($invoice->order_no, $data['payment_status']);

		//get updated invoice
		$return = $this->invoice->getInvoice($id);

		return $this->respondWithData($return);

	}


}
