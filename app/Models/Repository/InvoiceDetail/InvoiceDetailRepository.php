<?php namespace FutureEd\Models\Repository\InvoiceDetail;

use FutureEd\Models\Core\InvoiceDetail;


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

    public function getInvoiceDetailByInvoiceIdAndClassId($invoice_id,$class_id){
        try{
            $result = InvoiceDetail::invoiceId($invoice_id)->classId($class_id)->first();
            return !is_null($result) ? $result->toArray():null;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function deleteInvoiceDetailByInvoiceId($invoice_id){
        try{
            return InvoiceDetail::invoiceId($invoice_id)->delete();
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
}