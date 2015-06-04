<?php namespace FutureEd\Models\Repository\Invoice;


use FutureEd\Models\Core\Invoice;

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

                if(isset($criteria['subscription_id'])){

                    $invoice  = $invoice ->with('subscription')->subscription($criteria['subscription_id']);

                }

                if(isset($criteria['payment_status'])){

                    $invoice  = $invoice->with('subscription')->payment($criteria['payment_status']);

                }
            }



            $count = $invoice->count();

            if($limit > 0 && $offset >= 0) {
                $invoice = $invoice->with('subscription')->offset($offset)->limit($limit);
            }

        }




        return ['total' => $count, 'records' => $invoice->get()->toArray()];

    }



}