<?php namespace FutureEd\Models\Repository\SubscriptionPackage;


interface SubscriptionPackageRepositoryInterface {

	public function getSubscriptionPackages($criteria = [], $limit, $offset);

	public function getSubscriptionPackage($id);

	public function getSubscriptionCountries();

	public function addSubscriptionPackage($data);

	public function updateSubscriptionPackage($id, $data);

	public function deleteSubscriptionPackage($id);

}