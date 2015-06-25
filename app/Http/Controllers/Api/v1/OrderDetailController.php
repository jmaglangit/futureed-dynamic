<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Models\Repository\OrderDetail\OrderDetailRepositoryInterface;

class OrderDetailController extends ApiController{

    protected $order_detail;

    public function __construct(OrderDetailRepositoryInterface $order_detail){
        $this->order_detail = $order_detail;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id){
        return $this->respondWithData($this->order_detail->deleteOrderDetail($id));
    }
}