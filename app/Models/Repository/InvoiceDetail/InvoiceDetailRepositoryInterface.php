<?php namespace FutureEd\Models\Repository\InvoiceDetail;


interface InvoiceDetailRepositoryInterface {
    
    public function getInvoiceDetails($criteria = array(), $limit = 0, $offset = 0);
    public function addInvoiceDetail($data);
    public function getInvoiceDetailByInvoiceIdAndClassId($invoice_id,$class_id);
    public function deleteInvoiceDetailByInvoiceId($invoice_id);
    public function updateInvoiceDetail($id, $data);

}
