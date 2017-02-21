<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 2/20/17
 * Time: 9:50 AM
 */

namespace FutureEd\Http\Controllers\Api\Reports;

use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use FutureEd\Models\Repository\Invoice\InvoiceRepositoryInterface;

class InvoiceController extends ReportController {

	protected $invoice;

	protected $pdf;

	/**
	 * @param InvoiceRepositoryInterface $invoiceRepositoryInterface
	 * @param PDF $PDF
	 */
	public function __construct(
		InvoiceRepositoryInterface $invoiceRepositoryInterface,
		PDF $PDF
	){
		$this->invoice = $invoiceRepositoryInterface;
		$this->pdf = $PDF;
	}

	/**
	 * PDF download Invoice details
	 * @param $invoice_id
	 * @return \Illuminate\Http\Response
	 */
	public function getBillingInvoice($invoice_id){

		//get invoice
		$invoice = $this->invoice->getInvoice($invoice_id);

		$billing = [
			'invoice' => $invoice->toArray(),
		];

		$file_name = $billing['invoice']['order_no'] . '_FutureEd_Invoice';

		//export invoice into pdf
		$pdf = $this->pdf->loadView('export.billing.billing-invoice-pdf', $billing)->setPaper('a4')->setOrientation('portrait');

		return $pdf->download($file_name . '.' . 'pdf');
	}

}