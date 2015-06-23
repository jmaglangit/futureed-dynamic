<?php namespace FutureEd\Models\Repository\InvoiceDetail;

use FutureEd\Models\Core\InvoiceDetail;
use FutureEd\Models\Core\Invoice;


class InvoiceDetailRepository implements InvoiceDetailRepositoryInterface{
    
    public function getInvoiceDetails($criteria = array(), $limit = 0, $offset = 0)
    {
        //
    }
    
    public function addInvoiceDetail($data)
    {
        try{
            return InvoiceDetail::create($data)->toArray();
            
        }catch(Exception $e){
            return $e->getMessage();        
        }
    }

    //get invoice details with relation to classroom grade and invoice and subscription

    public function getDetails($invoice_no){

        $invoice_list = new InvoiceDetail();
        $invoice = new Invoice();
       
        $invoice = $invoice->select('invoice_no','payment_status','date_start','date_end','subscription_id','discount')
                           ->with('subscription')->where('invoice_no','=',$invoice_no)->get();

        if(empty($invoice->toArray())) {
            
            return $invoice;
        }

        $invoice_list = $invoice_list->with('grade','classroom')->where('invoice_no',"=",$invoice_no)->get();

        if($invoice_list) {
           $invoice = (object) $invoice[0];
           $invoice->invoices = $invoice_list->toArray();
        }

        $subtotal = 0;

        if($invoice->toArray()){

               foreach ($invoice->invoices as $k => $v) {

                       $subtotal +=  $v['price'];
               }
        }

        $invoice->price_discount = $subtotal * ($invoice->discount/100);
        $invoice->total = $subtotal - $invoice->price_discount;
        $invoice->subtotal = $subtotal; 

        return $invoice;
    }

    public function checkInvoiceIfExist($invoice_no){

        $invoice =  new InvoiceDetail();

        $invoice = $invoice->where('invoice_no',"=",$invoice_no)->first();

        return $invoice;

    }

    public function updateInvoice($invoice_no, $data){
     
     $invoice = new Invoice();
     $invoice = $invoice->where('invoice_no','=',$invoice_no);
 
       try{
        
         $invoice->update($data);
       } catch (Exception $e){
           throw new Exception($e->getMessage());
       }
     
       return true;
     }


}