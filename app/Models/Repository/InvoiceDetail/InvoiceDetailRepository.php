<?php namespace FutureEd\Models\Repository\InvoiceDetail;

use FutureEd\Models\Core\InvoiceDetail;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;


class InvoiceDetailRepository implements InvoiceDetailRepositoryInterface{
	use LoggerTrait;
	
	public function getInvoiceDetails($criteria = array(), $limit = 0, $offset = 0)
	{
		//
	}
	
	public function addInvoiceDetail($data)
	{
		DB::beginTransaction();
		
		try{
			$response = InvoiceDetail::create($data)->toArray();
			
		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	public function getInvoiceDetailByInvoiceIdAndClassId($invoice_id,$class_id){
		DB::beginTransaction();

		try{
			$result = InvoiceDetail::invoiceId($invoice_id)->classId($class_id)->first();
			$response = !is_null($result) ? $result->toArray():null;
		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	public function deleteInvoiceDetailByInvoiceId($invoice_id){
		DB::beginTransaction();

		try{
			$response = InvoiceDetail::invoiceId($invoice_id)->delete();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Update a record.
	 * @param $id
	 * @param $data
	 * @return bool|int|string
	 */

	public function updateInvoiceDetail($id, $data)
	{
		DB::beginTransaction();
		
		try{

			$response = InvoiceDetail::find($id)
							->update($data);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}
}