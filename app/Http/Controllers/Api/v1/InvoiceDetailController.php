<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\InvoiceDetailRequest;

use FutureEd\Models\Repository\InvoiceDetail\InvoiceDetailRepositoryInterface as InvoiceDetail;
use FutureEd\Models\Repository\Invoice\InvoiceRepositoryInterface;
use FutureEd\Models\Repository\Order\OrderRepositoryInterface;
use FutureEd\Models\Repository\OrderDetail\OrderDetailRepositoryInterface;
use Illuminate\Support\Facades\Input;

use FutureEd\Services\InvoiceServices;

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
	*
	* @var InvoiceServices
	*/
	protected $invoiceService;

	/**
	 * @param InvoiceDetail $detail
	 * @param InvoiceRepositoryInterface $invoice
	 * @param OrderRepositoryInterface $orderRepositoryInterface
	 */
	public function __construct(
		InvoiceDetail $detail,
		InvoiceRepositoryInterface $invoice,
		OrderRepositoryInterface $orderRepositoryInterface,
		InvoiceServices $invoiceService
	)
	{

		$this->detail = $detail;
		$this->invoice = $invoice;
		$this->order = $orderRepositoryInterface;
		$this->invoiceService = $invoiceService;
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

		$data = $request->only('id', 'payment_status', 'invoice_detail');

		$id = $data['id'];

		$return = $this->invoice->getInvoice($id);

		if (!$return) {

			return $this->respondErrorMessage(2120);
		}

		if ($data['payment_status'] == 'Paid') {

			$criteria =array('student_id' => $return['student_id'], 'payment_status' => 'Paid');

			$subject_id = $data['invoice_detail'][0]['classroom']['subject_id'];

			$result = $this->invoice->getInvoiceDetails($criteria ,0 ,0 );

			if ($this->invoiceService->compareInvoice($result, $subject_id, $id)) {

				return $this->respondErrorMessage(2080);
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
