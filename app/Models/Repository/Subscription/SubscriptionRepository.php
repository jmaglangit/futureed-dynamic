<?php
namespace FutureEd\Models\Repository\Subscription;

use FutureEd\Models\Core\Subscription;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class SubscriptionRepository implements SubscriptionRepositoryInterface {

    use LoggerTrait;

	/**
	 * Display a listing of subscriptions.
	 *
	 * @param	array	$criteria
	 * @param	int		$limit
	 * @param	int		$offset
	 *
	 * @return array
	 */
    public function getSubscriptions($criteria = array(), $limit = 0, $offset = 0) {

        DB::beginTransaction();

        try {

            $subscriptions = new Subscription();

            $count = 0;

            if (count($criteria) <= 0 && $limit == 0 && $offset == 0) {

                $count = $subscriptions->count();

            } else {

                if (count($criteria) > 0) {
                    if (isset($criteria['name'])) {
                        $subscriptions = $subscriptions->name($criteria['name']);
                    }

                    if (isset($criteria['status'])) {
                        $subscriptions = $subscriptions->status($criteria['status']);
                    }
                }

                $count = $subscriptions->count();

                if ($limit > 0 && $offset >= 0) {
                    $subscriptions = $subscriptions->offset($offset)->limit($limit);
                }

            }

            $subscriptions = $subscriptions->orderBy('name', 'asc');

            $response = ['total' => $count, 'records' => $subscriptions->get()->toArray()];

        } catch (\Exception $e) {

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
	 * @param	int	$id
	 *
	 * @return object
	 */
    public function getSubscription($id){

        DB::beginTransaction();

        try {

            $response = Subscription::find($id);

        } catch (\Exception $e) {

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
	 * @param  array	$subscription
	 *
	 * @return object
	 */
    public function updateSubscription($id,$subscription){

        DB::beginTransaction();

        try{

            $result = Subscription::find($id);

            $response =  !is_null($result) ? $result->update($subscription) : false;

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

    /**
     * @param $subscription
     * @return array|bool
     */
    public function addSubscription($subscription){

        DB::beginTransaction();

        try{

            $response = Subscription::create($subscription)->toArray();

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

    /**
     * Delete specific subscription.
     * @param $id
     * @return bool
     * @internal param id $subscription
     */
    public function deleteSubscription($id){

        DB::beginTransaction();

        try{

            $result = Subscription::find($id);

            $response = !is_null($result) ? $result->delete() : false;

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }
}