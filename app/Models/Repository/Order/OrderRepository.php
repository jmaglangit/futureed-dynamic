<?php namespace FutureEd\Models\Repository\Order;


use FutureEd\Models\Core\Order;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface{

	/**
     * @param array $criteria
     * @param int $limit
     * @param int $offset
     */
    public function getOrders($criteria = array(), $limit = 0, $offset = 0)
    {
        //
    }

	/**
     * @param $data
     * @return array|string
     */
    public function addOrder($data)
    {
        try{
            return Order::create($data)->toArray();
            
        }catch(Exception $e){
            return $e->getMessage();        
        }
    }

	/**
     * @param $id
     * @param $data
     * @return bool|int|string
     */
    public function updateOrder($id,$data){
        try{
            $result = Order::find($id);
            return !is_null($result) ? $result->update($data) : false;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

	/**
     * @return null
     */
    public function getNextOrderNo(){
        $result =  Order::orderBy('id','desc')->first();
        return !is_null($result) ? $result->toArray(): null;
    }

	/**
     * @param $order_no
     * @return null
     */
    public function getOrderByOrderNo($order_no){
        $result = Order::orderNo($order_no)->first();
        return !is_null($result) ? $result->toArray(): null;
    }

	/**
     * @param $id
     * @return bool|null|string
     */
    public function deleteOrder($id){
        try{
            $result = Order::find($id);
            return is_null($result) ? null : $result->delete();
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

	/**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|\Illuminate\Support\Collection|null|string|static
     */
    public function getOrder($id){
        try{
            return Order::with('invoice')->find($id);
        }catch (\Exception $e){
            return $e->getMessage();
        }
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