<?php namespace FutureEd\Models\Repository\Invoice;


use FutureEd\Models\Core\Invoice;
use FutureEd\Models\Core\ClientDiscount;


class InvoiceRepository implements InvoiceRepositoryInterface{


    public function getInvoiceDetails($criteria = [],$limit = 0, $offset = 0){

        $invoice = new Invoice();

        $count = 0;

        if(count($criteria) <= 0 && $limit == 0 && $offset == 0) {

            $count = $invoice->count();

            $invoice = $invoice->with('subscription');

        } else {



            if(count($criteria) > 0) {
                if(isset($criteria['order_no'])) {

                    $invoice = $invoice->with('subscription')->order($criteria['order_no']);

                }

                if(isset($criteria['subscription_name'])){

                    $invoice  = $invoice ->with('subscription')->subscription($criteria['subscription_name']);

                }

                if(isset($criteria['payment_status'])){

                    $invoice  = $invoice->with('subscription')->payment($criteria['payment_status']);

                }

                if(isset($criteria['client_id'])){
                    $invoice  = $invoice->with('subscription')->clientId($criteria['client_id']);
                }
            }



            $count = $invoice->count();

            if($limit > 0 && $offset >= 0) {
                $invoice = $invoice->with('subscription')->offset($offset)->limit($limit);
            }

        }




        return ['total' => $count, 'records' => $invoice->get()->toArray()];

    }

    public function addInvoice($data)
    {
        try{
            return Invoice::create($data)->toArray();

        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function getInvoice($id)
    {
        return Invoice::with('subscription')->find($id);
    }

    public function updateInvoice($id, $data){
        try{
            $result = Invoice::find($id);
            return !is_null($result) ? $result->update($data) : false;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    /**
     *  Get client discount to be used when adding invoice.
     *  @param $client_id int
     * @return object
     */

    public function getClientInvoiceDiscount($client_id)
    {
        return ClientDiscount::clientId($client_id)->get();
    }

    public function getNextInvoiceNo(){
        return Invoice::orderBy('id','desc')->first()->toArray();
    }


	//get invoice with relation to subscription and invoice_detail which related to classroom and client
	public function getDetails($id)
	{

		$invoice = new Invoice();

		//query relation to subscription and invoice_detail
		$invoice = $invoice->select('id', 'payment_status', 'date_start', 'date_end', 'subscription_id', 'discount')
			->with('subscription')->with('InvoiceDetail')->id($id);

		$invoice = $invoice->get();

		$subtotal = 0;
		$discount = 0;

		foreach ($invoice as $k => $v) {

			$discount = $v->discount;

			foreach ($v->InvoiceDetail as $key => $value) {

				$subtotal += $value->price;

			}
		}


		$invoice['price_discount'] = $subtotal * ($discount / 100);
		$invoice['total'] = $subtotal - $invoice['price_discount'];
		$invoice['subtotal'] = $subtotal;

		return $invoice;
	}




}