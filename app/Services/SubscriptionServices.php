<?php namespace FutureEd\Services;


use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Models\Repository\Invoice\InvoiceRepositoryInterface;
use FutureEd\Models\Repository\User\UserRepositoryInterface;

class SubscriptionServices {

	protected $user;
	protected $client;
	protected $invoices;

	/**
	 * Check if certain user has subscription.
	 * @param UserRepositoryInterface $userRepositoryInterface
	 * @param ClientRepositoryInterface $clientRepositoryInterface
	 * @param InvoiceRepositoryInterface $invoiceRepositoryInterface
	 */
	public function __construct(
		UserRepositoryInterface $userRepositoryInterface,
		ClientRepositoryInterface $clientRepositoryInterface,
		InvoiceRepositoryInterface $invoiceRepositoryInterface
	){
		$this->user = $userRepositoryInterface;
		$this->client = $clientRepositoryInterface;
		$this->invoices = $invoiceRepositoryInterface;
	}

	/**
	 * Check client parent has current subscription
	 * @param $client_id
	 * @return array
	 */
	public function checkParentSubscription($client_id){

		//get invoice purchase with subject,module

		$current_subscriptions = $this->invoices->getInvoiceDetails([
			'client_id' => $client_id,
			'current_subscription' => 1
		],0,0);

		$invoices = $current_subscriptions['records'];
		$subscription= [];


		foreach($invoices as $inv){

			$invoice = [];
			$invoice['order_no'] = $inv['order_no'];

			foreach($inv['invoice_detail'] as $i){

				$invoice['subject'][] = $i['classroom']['subject_id'];
			}

			$subscription[] = (object) $invoice;
		}

		return $subscription;
	}

}