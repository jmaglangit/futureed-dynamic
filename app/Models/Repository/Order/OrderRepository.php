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
}