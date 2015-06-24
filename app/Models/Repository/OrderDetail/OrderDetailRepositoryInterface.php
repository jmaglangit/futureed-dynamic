<?php

namespace FutureEd\Models\Repository\OrderDetail;

interface OrderDetailRepositoryInterface {
    public function addOrderDetail($data);
    public function getOrderDetailsByOrderId($order_id);
    public function getOrderDetailByStudentId($student_id);
}