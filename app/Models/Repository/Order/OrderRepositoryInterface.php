<?php namespace FutureEd\Models\Repository\Order;


interface OrderRepositoryInterface {
    
    public function getOrders($criteria = array(), $limit = 0, $offset = 0);
    public function addOrder($data);
    public function updateOrder($id,$data);
    public function getNextOrderNo();
    public function getOrderByOrderNo($order_no);
}