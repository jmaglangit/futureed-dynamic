<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/6/15
 * Time: 6:01 PM
 */

namespace FutureEd\Services;


use FutureEd\Models\Repository\Client\ClientRepositoryInterface;

class CheckClientBillingServices {
	public function __construct(ClientRepositoryInterface $clientRepositoryInterface)
	{
		$this->client = $clientRepositoryInterface;
	}

	public function clientDetails($id){
		return $this->client->getClientDetails($id);
	}
}