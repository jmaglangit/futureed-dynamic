<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\OrderRequest;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Order\OrderRepositoryInterface;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class OrderController extends ApiController {
    
    protected $order;
    
    public function __construct(OrderRepositoryInterface $order){
        $this->order = $order;
    }
    
    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    public function index()
    {
        
    }

    /**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */

    public function store(OrderRequest $request)
    {
        $input = $request->all();
        
        $order = $this->order->addOrder($input);
        return $this->respondWithData($order);
    }
}
