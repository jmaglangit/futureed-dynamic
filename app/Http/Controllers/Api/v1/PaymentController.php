<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\PaymentRequest;
use FutureEd\Models\Repository\Classroom\ClassroomRepositoryInterface;
use FutureEd\Models\Repository\Client\ClientRepositoryInterface;
use FutureEd\Models\Repository\Invoice\InvoiceRepositoryInterface;
use FutureEd\Models\Repository\Order\OrderRepositoryInterface;
use FutureEd\Models\Traits\LoggerTrait;
use FutureEd\Services\MailServices;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use PayPal\Api\Amount;
use PayPal\Api\ExecutePayment;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class PaymentController extends ApiController
{
    use LoggerTrait;

    private $_api_context;
    protected $invoice;
    protected $email;
    protected $classroom;
    protected $client;
    protected $order;

    public function __construct(InvoiceRepositoryInterface $invoice,
                                MailServices $email,
                                ClientRepositoryInterface $client,
                                ClassroomRepositoryInterface $classroom,
                                OrderRepositoryInterface $order)
    {
        $paypal_conf = config('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);

        $this->email = $email;
        $this->invoice = $invoice;
        $this->classroom = $classroom;
        $this->client = $client;
        $this->order = $order;
    }
    /**
     * 	Post payment to Paypal portal
     *	@params $request object
     *	@return callback_uri
     */
    public function postPayment(PaymentRequest $request)
    {
        $data = $request->all();

        //default currency to USD.
        $currency = "USD";
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item_1 = new Item();
        $item_1->setName('Payment for Future Lesson Seats')->setCurrency($currency)->setQuantity($data['quantity'])->setPrice($data['price']);

        // add item to list
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));

        $amount = new Amount();
        $total_amount = $data['quantity'] * $data['price'];
        $amount->setCurrency($currency)->setTotal($total_amount);

        $transaction = new Transaction();
        $transaction->setAmount($amount)->setItemList($item_list)->setDescription('FutureEd Classes');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('payment.status'))->setCancelUrl(URL::route('payment.status'));

        $payment = new Payment();
        $payment->setIntent('Sale')->setPayer($payer)->setRedirectUrls($redirect_urls)->setTransactions(array($transaction));

        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {

            return $this->respondWithData([
                'status' => 'error',
                'data' => $ex->getMessage()]);
        }

        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        // add payment ID to session
        Session::put('paypal_payment_id', $payment->getId());
        Session::put('paypal_payment_invoice_id', $data['invoice_id']);

        Session::put('success_callback_uri', $data['success_callback_uri']);
        Session::put('fail_callback_uri', $data['fail_callback_uri']);

        if(isset($data['client_id'])){
            Session::put('paypal_payment_client_id', $data['client_id']);
            Session::put('paypal_payment_order_no', $data['order_no']);
            Session::put('is_renewal', isset($data['renew']) ? $data['renew'] : 0);
        }

        if(isset($redirect_url)) {
            return $this->respondWithData([
                'status' => 'succcess',
                'url' => $redirect_url]);
        }

        return $this->respondWithData([
            'status' => 'error',
            'data' => 'Unknown error occurred']);
    }

    /**
     *	Return uri to be called from Paypal portal
     *
     */

    public function getPaymentStatus()
    {
        // Get the payment ID before session clear
        $payment_id = Session::get('paypal_payment_id');
        $invoice_id = Session::get('paypal_payment_invoice_id');
        $order_no = Session::get('paypal_payment_order_no');

        $order_id = $this->order->getOrderByOrderNo($order_no);
        $order_id = $order_id['id'];

        // clear the session payment ID
        Session::forget('paypal_payment_id');
        Session::forget('paypal_payment_invoice_id');

        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {

            $fail_callback_uri = Session::get('fail_callback_uri');
            $fail_callback_uri = $fail_callback_uri.'?token='.Input::get('token');
            return Redirect::away($fail_callback_uri);
        }

        $payment = Payment::get($payment_id, $this->_api_context);

        // PaymentExecution object includes information necessary
        // to execute a PayPal account payment.
        // The payer_id is added to the request query parameters
        // when the user is redirected from paypal back to your site
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));

        //Execute the payment
        try{
            $result = $payment->execute($execution, $this->_api_context);

            if($result->getState() == config('paypal.approved')) { // payment made
                //Update invoice status to paid.
                $data['payment_status'] = config('futureed.paid');
                $this->invoice->updateInvoice($invoice_id,$data);
                $this->order->updateOrder($order_id,$data);

                //send email
                if(Session::has('paypal_payment_client_id') && Session::has('client') ){
                    $client_id = Session::get('paypal_payment_client_id');
                    $is_renewal = Session::get('is_renewal');

                    Session::forget('paypal_payment_client_id');
                    Session::forget('paypal_payment_order_no');
                    Session::forget('is_renewal');

                    $client = $this->client->getClientDetails($client_id);
                    $client = $this->client->getClient($client->user_id,config('futureed.principal'));

                    //check if the client is principal. Only those teachers under a principal will receive a classroom assignment email.
                    if(!is_null($client)){
                        $classrooms = $this->classroom->getClassroomByOrderNo($order_no);

                        if(count($classrooms) > 0 ){
                            foreach($classrooms as $res){
                                //classroom / teacher
                                $data['name'] = $res['client']['first_name'].' '.$res['client']['last_name'];
                                $data['class_name'] = $res['name'];
                                $data['email'] = $res['client']['user']['email'];
                                $data['username'] = $res['client']['user']['username'];

                                //client
                                $data['school_name'] = $client['school']['name'];
                                $data['login_link'] = URL::to('/client/login');

                                if(!$is_renewal && $res['client']['client_role'] == config('futureed.teacher')){
                                    $this->email->sendTeacherAddClass($data);
                                }
                            }
                        }
                    }
                }

                $success_callback_uri = Session::get('success_callback_uri');
                $success_callback_uri = $success_callback_uri.'?paymentId='.$payment_id.'?token='.Input::get('token');
                return Redirect::away($success_callback_uri);
            }
            Session::set('paypal_token',Input::get('token'));

            $fail_callback_uri = Session::get('fail_callback_uri');
            $fail_callback_uri = $fail_callback_uri.'?token='.Input::get('token');
            return Redirect::away($fail_callback_uri);

        }catch (\Exception $ex){

            $this->errorLog($ex->getMessage());

            $fail_callback_uri = Session::get('fail_callback_uri');
            $fail_callback_uri = $fail_callback_uri.'?token='.Input::get('token');
            return Redirect::away($fail_callback_uri);
        }
    }
}