<?php
namespace FutureEd\Models\Repository\Subscription;

interface SubscriptionRepositoryInterface {

    public function getSubscriptions($criteria = array(), $limit = 0, $offset = 0);
    public function getSubscription($id);
    public function updateSubscription($subscription);
    public function addSubscription($subscription);
    public function deleteSubscription($id);
}