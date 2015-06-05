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

    //get invoice details with relation to classroom grade and invoice

    public function getDetails($invoice_no){

        $invoice = new InvoiceDetail();
        $sub_invoice = new Invoice();

        $invoice = $invoice->with('classroom','invoice','grade')->where('invoice_no',"=",$invoice_no)->get()->toArray();
        
        $invoice_details = [];
        $subscription_id = null;
        $subtotal = 0;
        $discount = 0;
        $total_discount =0;
        $total = 0;


        if($invoice){

             $invoice_details = $invoice[0]['invoice'];

               foreach ($invoice_details as $k => $v) {

                       $subtotal +=  $v['total_amount'];
                     $subscription_id = $v['subscription_id'];
                     $discount = $v['discount'];
               }

               $sub_invoice = $sub_invoice->with('subscription')->subscription($subscription_id)->first()->toArray();
               $sub_invoice = $sub_invoice['subscription'];
               $invoice['subscription'] = $sub_invoice;

        }

        $total_discount = $subtotal * ($discount/100);
        $total = $subtotal - $total_discount;
        $invoice['subtotal'] = $subtotal;
        $invoice['discount'] = $discount;
        $invoice['price_discount'] = $total_discount;
        $invoice['total'] = $total;
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