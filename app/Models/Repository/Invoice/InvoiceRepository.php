<?php namespace FutureEd\Models\Repository\Invoice;


use FutureEd\Models\Core\Invoice;
use FutureEd\Models\Core\ClientDiscount;


class InvoiceRepository implements InvoiceRepositoryInterface{

    /**
     * Get list of invoice based with optional pagination.
     * @param array $criteria
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getInvoiceDetails($criteria = [], $limit = 0, $offset = 0)
    {

        $invoice = new Invoice();

        $count = 0;

        if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

            $count = $invoice->count();

            $invoice = $invoice->with('subscription');

        } else {


            if (count($criteria) > 0) {
                if (isset($criteria['order_no'])) {

                    $invoice = $invoice->with('subscription')->order($criteria['order_no']);

                }

                if (isset($criteria['subscription_name'])) {

                    $invoice = $invoice->with('subscription')->subscription($criteria['subscription_name']);

                }

                if (isset($criteria['payment_status'])) {

                    $invoice = $invoice->with('subscription')->payment($criteria['payment_status']);

                }

                if (isset($criteria['client_id'])) {
                    $invoice = $invoice->with('subscription')->clientId($criteria['client_id']);
                }
            }


            $count = $invoice->count();

            if ($limit > 0 && $offset >= 0) {
                $invoice = $invoice->with('subscription')->offset($offset)->limit($limit);
            }

        }

        return ['total' => $count, 'records' => $invoice->get()->toArray()];
    }

    /**
     * Add new Invoice
     * @param $data
     * @return array|string
     */
    public function addInvoice($data)
    {
        try {
            return Invoice::create($data)->toArray();

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Get invoice info.
     * @param $id
     * @return Object
     */
    public function getInvoice($id)
    {
        return Invoice::with('subscription','order')->find($id);
    }

    /**
     * Update invoice based on the data needed.
     * @param $id
     * @param $data
     * @return bool|int|string
     */
    public function updateInvoice($id, $data)
    {
        try {
            $result = Invoice::find($id);
            return !is_null($result) ? $result->update($data) : false;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     *  Get client discount to be used when adding invoice.
     * @param $client_id int
     * @return object
     */

    public function getClientInvoiceDiscount($client_id)
    {
        return ClientDiscount::clientId($client_id)->get();
    }

    /**
     * Get next invoice data from the storage.
     * @return array
     */
    public function getNextInvoiceNo()
    {
        return Invoice::orderBy('id', 'desc')->first()->toArray();
    }


    /**
     * Get invoice with relation to subscription and invoice_detail which related to classroom and client
     * @param $id
     * @return Invoice
     */
    public function getDetails($id)
    {

        $invoice = new Invoice();

        //query relation to subscription and invoice_detail
        $invoice = $invoice->select('id', 'payment_status', 'date_start', 'date_end', 'subscription_id', 'discount')
            ->with('subscription')->with('InvoiceDetail')->id($id);


        $subtotal = 0;

        $invoice = $invoice->first();

        foreach ($invoice['InvoiceDetail'] as $key => $value) {

            $subtotal += $value['price'];

        }

        $invoice->price_discount= $subtotal * ($invoice['discount'] / 100);
        $invoice->total = $subtotal - $invoice['price_discount'];
        $invoice->subtotal =$subtotal;


        return $invoice;
    }

    /**
     * Delete invoice from storage.
     * @param $id
     * @return bool|null|string
     */
    public function deleteInvoice($id){
        try{
            $result = Invoice::find($id);
            return is_null($result) ? null : $result->delete();
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }




}