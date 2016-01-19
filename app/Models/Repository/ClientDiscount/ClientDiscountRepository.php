<?php
namespace FutureEd\Models\Repository\ClientDiscount;

use FutureEd\Models\Core\Client;
use FutureEd\Models\Core\ClientDiscount;

class ClientDiscountRepository implements ClientDiscountRepositoryInterface
{

	/**
	 * Display a listing of client discounts.
	 *
	 * @param    array $criteria
	 * @param    int $limit
	 * @param    int $offset
	 *
	 * @return array
	 */
	public function getClientDiscounts($criteria = array(), $limit = 0, $offset = 0)
	{
		DB::beginTransaction();

		try{
			$clientDiscounts = new ClientDiscount();

			$count = 0;

			$clientDiscounts = $clientDiscounts->with('client');

			if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

				$count = $clientDiscounts->count();

			} else {

				if (count($criteria) > 0) {
					if (isset($criteria['name'])) {
						$clientDiscounts = $clientDiscounts->name($criteria['name']);
					}
					if (isset($criteria['client_role'])) {
						$clientDiscounts = $clientDiscounts->role($criteria['client_role']);
					}
					if (isset($criteria['client_id'])) {
						$clientDiscounts = $clientDiscounts->clientid($criteria['client_id']);
					}

				}

				$count = $clientDiscounts->count();

				if ($limit > 0 && $offset >= 0) {
					$clientDiscounts = $clientDiscounts->offset($offset)->limit($limit);
				}

			}

			$response = ['total' => $count, 'records' => $clientDiscounts->get()->toArray()];

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Display specific subscription by id.
	 *
	 * @param    int $id
	 *
	 * @return object
	 */
	public function getClientDiscount($id)
	{
		DB::beginTransaction();

		try{
			$response = ClientDiscount::with('client')->find($id);

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Update specific subscription.
	 *
	 * @param  array $subscription
	 *
	 * @return object
	 */

	public function updateClientDiscount($id, $clientDiscount)
	{
		DB::beginTransaction();

		try {
			$result = ClientDiscount::find($id);
			$response = !is_null($result) ? $result->update($clientDiscount) : false;

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Add specific subscription.
	 *
	 * @param  array $subscription
	 *
	 * @return object
	 */

	public function addClientDiscount($clientDiscount)
	{
		DB::beginTransaction();

		try {
			$response = ClientDiscount::create($clientDiscount)->toArray();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Delete specific subscription.
	 *
	 * @param  id $subscription
	 *
	 * @return boolean
	 */
	public function deleteClientDiscount($id)
	{
		DB::beginTransaction();

		try {
			$result = ClientDiscount::find($id);
			$response = !is_null($result) ? $result->delete() : false;

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	public function checkClient($client_id)
	{
		DB::beginTransaction();

		try{
			$response = ClientDiscount::clientid($client_id)->pluck('id');

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}
}