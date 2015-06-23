<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\InvoiceDetailRequest;

use FutureEd\Models\Repository\InvoiceDetail\InvoiceDetailRepositoryInterface as InvoiceDetail;
use Illuminate\Support\Facades\Input;

class InvoiceDetailController extends ApiController {

    protected $detail;

    public function __construct(InvoiceDetail $detail){

            $this->detail = $detail;
    }


	public function viewInvoiceDetail()
	{
        $invoice_no = null;

              if(Input::get('invoice_no')) {

                  $invoice_no = Input::get('invoice_no');
               }

        $detail = $this->detail->getDetails($invoice_no);

        return $this->respondWithData($detail);

	}


    public function editInvoiceDetails(InvoiceDetailRequest $request)
    {

        $data = $request->only('invoice_no','payment_status');

        $invoice = $data['invoice_no'];
        $return = $this->detail->checkInvoiceIfExist($invoice);

        if(!$return){

            return $this->respondErrorMessage(2120);
        }

        $update = $this->detail->updateInvoice($invoice, $data);
        return $this->respondWithData($update);

    }


}
