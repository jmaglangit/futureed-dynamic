<?php
/**
 * Created by PhpStorm.
 * User: amcuserguy
 * Date: 6/11/15
 * Time: 1:47 PM
 */

namespace FutureEd\Services;

//use Illuminate\Support\Facades\Config;

class InvoiceServices {

    public function createOrderNo($clientId,$orderId)
    {
        if( strlen($clientId) < 4 )
            $clientId = str_pad($clientId, config('futureed.client_id_zero_fill'),'0',STR_PAD_LEFT);

        if( strlen($orderId) < 6 )
            $orderId = str_pad($orderId, config('futureed.order_id_zero_fill'),'0',STR_PAD_LEFT);

        $year = date('Y');

        return $clientId.'-'.$orderId.'-'.$year;
    }

    public function createInvoiceNo($invoice_no){
        if(strlen($invoice_no) < 10)
            $invoice_no = str_pad($invoice_no, config('futureed.invoice_id_zero_fill'),'0',STR_PAD_LEFT);

        return $invoice_no;
    }
}