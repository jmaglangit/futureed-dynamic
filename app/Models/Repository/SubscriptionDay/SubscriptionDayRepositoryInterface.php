<?php namespace FutureEd\Models\Repository\SubscriptionDay;

interface SubscriptionDayRepositoryInterface {

	public function getSubscriptionDays($criteria = [] ,$limit = 0, $offset = 0);

	public function getSubscriptionDay($id);

	public function addSubscriptionDay($data);

	public function updateSubscriptionDay($id, $data);

	public function deleteSubscriptionDay($id);
}