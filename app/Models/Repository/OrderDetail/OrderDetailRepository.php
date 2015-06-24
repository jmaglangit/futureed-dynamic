<?php
namespace FutureEd\Models\Repository\OrderDetail;

use FutureEd\Models\Core\OrderDetail;
use FutureEd\Models\Repository\OrderDetail\OrderDetailRepositoryInterface;

class OrderDetailRepository implements OrderDetailRepositoryInterface{

    /**
     * Add record to storage
     * @param $data
     * @return array|string
     */
    public function addOrderDetail($data){
        try{
            return OrderDetail::create($data)->toArray();
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Get order details by order_id
     * @param $order_id
     * @return object
     */
    public function getOrderDetailsByOrderId($order_id){
        return OrderDetail::orderId($order_id)->with('student')->get();
    }

    /**
     * Get order details by student id
     * @param $order_id
     * @return object
     */
    public function getOrderDetailByStudentId($student_id){
        try{
            $result = OrderDetail::studentId($student_id)->first();
            return is_null($result) ? null : $result->toArray();
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }


}