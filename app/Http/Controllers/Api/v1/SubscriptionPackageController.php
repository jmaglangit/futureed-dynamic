<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\SubscriptionPackageRequest;
use FutureEd\Models\Core\SubscriptionPackages;
use FutureEd\Models\Repository\SubscriptionPackage\SubscriptionPackageRepositoryInterface;
use Illuminate\Support\Facades\Input;
use FutureEd\Services\UserServices;
use FutureEd\Services\SessionServices;
use FutureEd\Services\TokenServices;
use Illuminate\Support\Facades\Session;
use FutureEd\Models\Repository\Classroom\ClassroomRepositoryInterface;
use FutureEd\Models\Repository\Order\OrderRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\Invoice\InvoiceRepositoryInterface;
use FutureEd\Services\InvoiceServices;
use FutureEd\Models\Repository\InvoiceDetail\InvoiceDetailRepositoryInterface;
use FutureEd\Models\Core\Invoice;




class SubscriptionPackageController extends ApiController {

	protected $subscription_package;
	protected $student;
	protected $user;
	protected $user_service;
	protected $classroom;
	protected $order;
	protected $invoice;
	protected $invoice_detail;


	public function __construct(
		UserServices $userServices,
		SessionServices $sessionServices,
		OrderRepositoryInterface $order,
		studentRepositoryInterface $studentRepositoryInterface,
		ClassroomRepositoryInterface $classroom,
		InvoiceServices	$invoice_services,
		InvoiceDetailRepositoryInterface $invoice_detail,
		InvoiceRepositoryInterface $invoice,								
		SubscriptionPackageRepositoryInterface $subscriptionPackageRepositoryInterface
	){
		$this->subscription_package = $subscriptionPackageRepositoryInterface;
		$this->student = $studentRepositoryInterface;
		$this->classroom = $classroom;
		$this->order = $order;	
        $this->user_service = $userServices;
        $this->user = $sessionServices;
		$this->invoice = $invoice;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$criteria = [];
		$limit = 0;
		$offset = 0;

		if(Input::get('subject_id')){
			$criteria['subject_id'] = Input::get('subject_id');
		}

		if(Input::get('days_id')){
			$criteria['days_id'] = Input::get('days_id');
		}

		if(Input::get('subscription_id')){
			$criteria['subscription_id'] = Input::get('subscription_id');
		}

		if(Input::get('country_id')){
			$criteria['country_id'] = Input::get('country_id');
		}

		if(Input::get('status')){
			$criteria['status'] = Input::get('status');
		}

		if(Input::get('limit')){
			$limit = Input::get('limit');
		}

		if(Input::get('offset')){
			$offset = Input::get('offset');
		}

        $sess_name = Session::has('student') ? 'student' : 'client';
        $data = Session::get($sess_name);
        $user = json_decode($data, true);
        $invoices = $this->invoice->getInvoiceDetails([
            $sess_name.'_id' => $user['id'],
            'payment_status' => config('futureed.paid')
        ]);

        if($invoices['total']){
            $criteria['trial'] = 1;
        }else{
            $criteria['trial'] = 0;
        }

		return $this->respondWithData($this->subscription_package->getSubscriptionPackages($criteria,$limit,$offset));
	}

	/**
	 * Get subscription package.
	 * @param $id
	 */
	public function show($id){

		return $this->respondWithData($this->subscription_package->getSubscriptionPackage($id));
	}

	/**
	 * store a new subscription package
	 * @param SubscriptionPackageRequest $request
	 * @return mixed
	 */
	public function store(SubscriptionPackageRequest $request){

		$data = $request->all();

		return $this->respondWithData($this->subscription_package->addSubscriptionPackage($data));
	}

	/**
	 * update a subscription package
	 * @param $id
	 * @param SubscriptionPackageRequest $request
	 * @return mixed
	 */
	public function update($id, SubscriptionPackageRequest $request){

		$data = $request->all();

		return $this->respondWithData($this->subscription_package->updateSubscriptionPackage($id,$data));
	}

	/**
	 * delete a subscription package
	 * @param $id
	 * @return mixed
	 */
	public function destroy($id){

		return $this->respondWithData($this->subscription_package->deleteSubscriptionPackage($id));
	}

}
