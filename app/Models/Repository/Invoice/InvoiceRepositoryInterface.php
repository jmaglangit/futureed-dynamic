<?php namespace FutureEd\Models\Repository\Invoice;


interface InvoiceRepositoryInterface {

    public function getInvoiceDetails($criteria = [],$limit = 0, $offset = 0);
    public function addInvoice($data);
    public function getInvoice($id);
    public function getClientInvoiceDiscount($client_id);
    public function getNextInvoiceNo();
}