<?php

namespace FutureEd\Models\Repository\OrderDetail;

interface OrderDetailRepositoryInterface {
    public function addOrderDetail($data);
    public function getOrderDetailsByOrderId($order_id);
    public function deleteOrderDetail($id);
    public function getOrderDetailByOrderIdAndStudentId($order_id,$student_id);
    public function deleteOrderDetailByOrderId($order_id);
}