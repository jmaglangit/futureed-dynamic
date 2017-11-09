<?php
namespace FutureEd\Models\Repository\ClientDiscount;

interface ClientDiscountRepositoryInterface
{

	public function getClientDiscounts($criteria = array(), $limit = 0, $offset = 0);

	public function getClientDiscount($id);

	public function updateClientDiscount($id, $clientDiscount);

	public function addClientDiscount($clientDiscount);

	public function deleteClientDiscount($id);

	public function checkClient($client_id);

}