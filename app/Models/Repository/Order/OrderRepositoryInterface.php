<?php namespace FutureEd\Models\Repository\Order;


interface OrderRepositoryInterface {

    public function addOrder($data);

    public function updateOrder($id, $data);

    public function getNextOrderNo();

    public function getOrderByOrderNo($order_no);

    public function deleteOrder($id);

    public function getOrder($id);

    public function updateOrderPaymentStatusByOrderNo($order_no, $payment_status);
}