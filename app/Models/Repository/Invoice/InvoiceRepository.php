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
}