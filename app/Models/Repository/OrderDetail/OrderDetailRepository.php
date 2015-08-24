<?php
namespace FutureEd\Models\Repository\OrderDetail;

use FutureEd\Models\Core\OrderDetail;

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
     * Delete record from storage
     * @param $id
     * @return bool|null|string
     */
    public function deleteOrderDetail($id){
        try{
            $result = OrderDetail::find($id);
            return is_null($result) ? false :  $result->delete();
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
    /**
     * Get order details by student id and order_id
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

    /**
     * Get record from storage by order_id and student_id
     * @param $order_id
     * @return bool|null|string
     */
    public function getOrderDetailByOrderIdAndStudentId($order_id,$student_id){
        try{
            $result = OrderDetail::studentId($student_id)->orderId($order_id)->first();
            return is_null($result) ? null : $result->toArray();
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Delete record from storage by order_id
     * @param $order_id
     * @return bool|null|string
     */
    public function deleteOrderDetailByOrderId($order_id){
        try{
            return OrderDetail::orderId($order_id)->delete();
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

	/**
	 * Update a record.
	 * @param $id
	 * @param $data
	 * @return bool|int|string
	 */

	public function updateOrderDetail($id, $data)
	{
		try{

			return OrderDetail::find($id)
				->update($data);

		} catch (Exception $e) {

			throw new Exception($e->getMessage());
		}

	}


}