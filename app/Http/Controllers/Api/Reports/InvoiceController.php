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


	public function __construct(
		InvoiceRepositoryInterface $invoiceRepositoryInterface,
		PDF $PDF
	){
		$this->invoice = $invoiceRepositoryInterface;
		$this->pdf = $PDF;
	}


	//PDF download Invoice details

	public function getBillingInvoice($invoice_id){

		//get invoice
		$invoice = $this->invoice->getInvoice($invoice_id);

//		dd($invoice->toArray());


		$information = [
			'header' => [

			],
			'footer' => ''
		];

		$billing = [
			'invoice' => $invoice->toArray(),
		];

		$file_name = $billing['invoice']['order_no'] . '_FutureEd_Invoice';

//		dd($billing);

		//export invoice into pdf
		$pdf = $this->pdf->loadView('export.invoice.billing-invoice-pdf', $billing)->setPaper('a4')->setOrientation('portrait');

		return $pdf->download($file_name . '.' . 'pdf');

	}

}