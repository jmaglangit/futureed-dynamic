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
}