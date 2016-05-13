<?php namespace FutureEd\Models\Repository\SubscriptionPackage;


interface SubscriptionPackageRepositoryInterface {

	public function getSubscriptionPackage($criteria = [], $limit, $offset);

	public function getSubscriptionCountries();

}