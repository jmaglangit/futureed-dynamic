<?php namespace FutureEd\Models\Repository\Order;


use FutureEd\Models\Core\Order;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface{

    use LoggerTrait;

	/**
     * @param $data
     * @return array|string
     */
    public function addOrder($data)
    {
        DB::beginTransaction();

        try{

            $response = Order::create($data)->toArray();
            
        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

	/**
     * @param $id
     * @param $data
     * @return bool|int|string
     */
    public function updateOrder($id,$data){

        DB::beginTransaction();

        try{
            $result = Order::find($id);
            $response = !is_null($result) ? $result->update($data) : false;

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

	/**
     * @return null
     */
    public function getLastOrderNo(){

        DB::beginTransaction();

        try {
            $result = Order::orderBy('id', 'desc')->first();
            $response = !is_null($result) ? $result->toArray() : null;

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

	/**
     * @param $order_no
     * @return null
     */
    public function getOrderByOrderNo($order_no){

        DB::beginTransaction();

        try {
            $result = Order::orderNo($order_no)->first();
            $response = !is_null($result) ? $result->toArray() : null;

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

	/**
     * @param $id
     * @return bool|null|string
     */
    public function deleteOrder($id){

        DB::beginTransaction();

        try{
            $result = Order::find($id);
            $response = is_null($result) ? null : $result->delete();

        }catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

	/**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection|null|string|static
     */
    public function getOrder($id){

        DB::beginTransaction();

        try{
            $response = Order::with('invoice')->find($id);

        }catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

	/**
     * @param $order_no
     * @param $payment_status
     * @return bool
     */
    public function updateOrderPaymentStatusByOrderNo($order_no, $payment_status){

        DB::beginTransaction();

        try{

            $response = Order::where('order_no',$order_no);

            $response = $response->update([
                'payment_status' => $payment_status
            ]);

        }catch(\Exception $e){

            DB::rollback();

            return false;
        }

        DB::commit();

        return $response;

    }
}