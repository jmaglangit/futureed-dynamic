<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\InvoiceDetailRequest;

use FutureEd\Models\Repository\InvoiceDetail\InvoiceDetailRepositoryInterface as InvoiceDetail;
use FutureEd\Models\Repository\Invoice\InvoiceRepositoryInterface;
use Illuminate\Support\Facades\Input;

class InvoiceDetailController extends ApiController {

    protected $detail;
	protected $invoice;

    public function __construct(InvoiceDetail $detail, InvoiceRepositoryInterface $invoice){

		$this->detail = $detail;
		$this->invoice = $invoice;
    }


	public function viewInvoiceDetail()
	{

        $id = null;

		if(Input::get('id')) {

			$id = Input::get('id');
		}

		$return = $this->invoice->getInvoice($id);

		if(!$return){

			return $this->respondErrorMessage(2120);
		}

        $detail = $this->invoice->getDetails($id);

        return $this->respondWithData($detail);

	}


    public function editInvoiceDetails(InvoiceDetailRequest $request)
    {

		$data = $request->only('id', 'payment_status');

		$id = $data['id'];
		$return = $this->invoice->getInvoice($id);

		if (!$return) {

			return $this->respondErrorMessage(2120);
		}

		//update invoice
		$this->invoice->updateInvoice($id, $data);

		//get updated invoice
		$return = $this->invoice->getInvoice($id);

		return $this->respondWithData($return);

    }


}
