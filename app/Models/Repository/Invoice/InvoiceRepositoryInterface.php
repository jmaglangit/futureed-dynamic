<?php namespace FutureEd\Models\Repository\Invoice;


interface InvoiceRepositoryInterface {

    public function getInvoiceDetails($criteria = [],$limit = 0, $offset = 0);


}