<?php namespace FutureEd\Models\Repository\Invoice;


use FutureEd\Models\Core\Invoice;
use FutureEd\Models\Core\ClientDiscount;
use FutureEd\Models\Core\User;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;


class InvoiceRepository implements InvoiceRepositoryInterface{
	use LoggerTrait;

	/**
	 * Get list of invoice based with optional pagination.
	 * @param array $criteria
	 * @param int $limit
	 * @param int $offset
	 * @return array
	 */
	public function getInvoiceDetails($criteria = [], $limit = 0, $offset = 0)
	{
		DB::beginTransaction();

		try{
			$invoice = new Invoice();

			if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

				$count = $invoice->count();

				$invoice = $invoice->with('subscription','invoiceDetail');

			} else {

				$invoice = $invoice->with('subscription','invoiceDetail');

				if (count($criteria) > 0) {
					if (isset($criteria['order_no'])) {

						$invoice = $invoice->order($criteria['order_no']);

					}

					if (isset($criteria['subscription_name'])) {

						$invoice = $invoice->subscription($criteria['subscription_name']);

					}

					if (isset($criteria['payment_status'])) {

						$invoice = $invoice->payment($criteria['payment_status']);

					}

					if (isset($criteria['client_id'])) {
						$invoice = $invoice->clientId($criteria['client_id']);
					}

					if (isset($criteria['student_id'])) {
						$invoice = $invoice->studentId($criteria['student_id']);
					}

					//add checking on current subscription.
					if(isset($criteria['current_subscription']) && $criteria['current_subscription'] == 1){

						$invoice = $invoice->current();

					}

				}


				$count = $invoice->count();

				if ($limit > 0 && $offset >= 0) {
					$invoice = $invoice->offset($offset)->limit($limit);
				}

				$invoice = $invoice->orderBy('id', 'desc');

			}

			$response = ['total' => $count, 'records' => $invoice->get()->toArray()];

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Add new Invoice
	 * @param $data
	 * @return array|string
	 */
	public function addInvoice($data)
	{
		DB::beginTransaction();

		try {
			$response = Invoice::create($data)->toArray();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get invoice info.
	 * @param $id
	 * @return Object
	 */
	public function getInvoice($id)
	{
		DB::beginTransaction();

		try{
			$response = Invoice::with('subscription','subscriptionPackage','order','invoiceDetail','client','student')->find($id);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Update invoice based on the data needed.
	 * @param $id
	 * @param $data
	 * @return bool|int|string
	 */
	public function updateInvoice($id, $data)
	{
		DB::beginTransaction();

		try{
			$result = Invoice::find($id);
			$response = !is_null($result) ? $result->update($data) : false;

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 *  Get client discount to be used when adding invoice.
	 * @param $client_id int
	 * @return object
	 */

	public function getClientInvoiceDiscount($client_id)
	{
		DB::beginTransaction();

		try{
			$response = ClientDiscount::clientId($client_id)->get();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get next invoice data from the storage.
	 * @return array
	 */
	public function getNextInvoiceNo()
	{
		DB::beginTransaction();

		try{
			$response = Invoice::orderBy('id', 'desc')->first()->toArray();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}


	/**
	 * Get invoice with relation to subscription and invoice_detail which related to classroom and client
	 * @param $id
	 * @return Invoice
	 */
	public function getDetails($id)
	{
		DB::beginTransaction();

		try{
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


			$response = $invoice;

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Delete invoice from storage.
	 * @param $id
	 * @return bool|null|string
	 */
	public function deleteInvoice($id){
		DB::beginTransaction();

		try{
			$result = Invoice::find($id);
			$response = is_null($result) ? null : $result->delete();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}


	/**
	 * get invoice by order_no.
	 * @param $order_no
	 * @return bool|null|string
	 */

	public function getInvoiceByOrderNo($order_no,$status){
		DB::beginTransaction();

		try{
			$invoice = new Invoice();

			//query relation to subscription and invoice_detail
			$response = $invoice->with('subscription')
				->with('InvoiceDetail')
				->order($order_no)
				->status($status)
				->get();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * update invoice status.
	 * @param $id
	 * @param $status
	 * @return bool|int
	 */
	public function updateStatus($id,$status){

		DB::beginTransaction();

		try{

			$response = Invoice::where('id',$id)->update([
				'status' => $status
			]);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;

	}
}