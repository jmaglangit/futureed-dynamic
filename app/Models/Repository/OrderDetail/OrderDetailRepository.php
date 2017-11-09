<?php
namespace FutureEd\Models\Repository\OrderDetail;

use FutureEd\Models\Core\OrderDetail;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class OrderDetailRepository implements OrderDetailRepositoryInterface{

    use LoggerTrait;

    /**
     * Add record to storage
     * @param $data
     * @return array|string
     */
    public function addOrderDetail($data){

        DB::beginTransaction();

        try{

            $response = OrderDetail::create($data)->toArray();

        }catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

    /**
     * Get order details by order_id
     * @param $order_id
     * @return object
     */
    public function getOrderDetailsByOrderId($order_id){

        DB::beginTransaction();

        try{

            $response = OrderDetail::orderId($order_id)->with('student')->get();

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

    /**
     * Delete record from storage
     * @param $id
     * @return bool|null|string
     */
    public function deleteOrderDetail($id){

        DB::beginTransaction();

        try{
            $result = OrderDetail::find($id);
            $response =  is_null($result) ? false :  $result->delete();

        }catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

    /**
     * Get order details by student id and order_id
     * @param $order_id
     * @return object
     */
    public function getOrderDetailByStudentId($student_id){

        DB::beginTransaction();

        try{
            $result = OrderDetail::studentId($student_id)->first();
            $response = is_null($result) ? null : $result->toArray();

        }catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

    /**
     * Get record from storage by order_id and student_id
     * @param $order_id
     * @return bool|null|string
     */
    public function getOrderDetailByOrderIdAndStudentId($order_id,$student_id){

        DB::beginTransaction();

        try{
            $result = OrderDetail::studentId($student_id)->orderId($order_id)->first();
            $response = is_null($result) ? null : $result->toArray();

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

    /**
     * Delete record from storage by order_id
     * @param $order_id
     * @return bool|null|string
     */
    public function deleteOrderDetailByOrderId($order_id){

        DB::beginTransaction();

        try{

            $response = OrderDetail::orderId($order_id)->delete();

        }catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

	/**
	 * Update a record.
	 * @param $id
	 * @param $data
	 * @return bool|int|string
	 */
	public function updateOrderDetail($id, $data)
	{
        DB::beginTransaction();

		try{

			$response = OrderDetail::find($id)
				->update($data);

		} catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
	}


}