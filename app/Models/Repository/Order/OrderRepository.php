<?php namespace FutureEd\Models\Repository\Order;


use FutureEd\Models\Core\Order;

class OrderRepository implements OrderRepositoryInterface{
    
    public function getOrders($criteria = array(), $limit = 0, $offset = 0)
    {
        //
    }
    
    public function addOrder($data)
    {
        try{
            return Order::create($data)->toArray();
            
        }catch(Exception $e){
            return $e->getMessage();        
        }
    }

    public function updateOrder($id,$data){
        try{
            $result = Order::find($id);
            return !is_null($result) ? $result->update($data) : false;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function getNextOrderNo(){
        $result =  Order::orderBy('id','desc')->first();
        return !is_null($result) ? $result->toArray(): null;
    }

    public function getOrderByOrderNo($order_no){
        $result = Order::orderNo($order_no)->first();
        return !is_null($result) ? $result->toArray(): null;
    }

    public function deleteOrder($id){
        try{
            $result = Order::find($id);
            return is_null($result) ? null : $result->delete();
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function getOrder($id){
        try{
            return Order::with('invoice')->find($id);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
}