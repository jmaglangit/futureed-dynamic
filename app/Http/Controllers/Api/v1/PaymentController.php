<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\PaymentRequest;
use FutureEd\Models\Repository\Invoice\InvoiceRepositoryInterface;
use Illuminate\Support\Facades\Input;
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
    private $_api_context;
    protected $invoice;


    public function __construct(InvoiceRepositoryInterface $invoice)
    {
        $paypal_conf = config('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
        $this->invoice = $invoice;
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

        //dd($redirect_url);
        if(isset($redirect_url)) {
            // redirect to paypal
            //return Redirect::away($redirect_url);

            return $this->respondWithData([
                'status' => 'succcess',
                'url' => $redirect_url]);
        }

        /*
        return Redirect::route('original.route')
                       ->with('error', 'Unknown error occurred');
        */

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

        // clear the session payment ID
        Session::forget('paypal_payment_id');
        Session::forget('paypal_payment_invoice_id');

        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            /*
           return Redirect::route('original.route')
                           ->with('error', 'Payment failed');
           */
            return $this->respondWithData([
                'status' => 'error',
                'data' => 'Payment failed'
            ]);
        }

        $payment = Payment::get($payment_id, $this->_api_context);

        // PaymentExecution object includes information necessary
        // to execute a PayPal account payment.
        // The payer_id is added to the request query parameters
        // when the user is redirected from paypal back to your site
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));

        //Execute the payment
        $result = $payment->execute($execution, $this->_api_context);

        // DEBUG RESULT, remove it later
        //echo '<pre>';print_r($result);echo '</pre>';exit;

        if ($result->getState() == 'approved') { // payment made
            //Update invoice status to paid.
            $data['payment_status'] = config('futureed.paid');
            $this->invoice->updateInvoice($invoice_id,$data);

            /*
               return Redirect::route('original.route') // front-end dev will provide a route here.
                                ->with('success', 'Payment success');
               */
            return $this->respondWithData([
                'status' => 'success',
                'data' => 'Payment success'
            ]);
        }
        /*
       return Redirect::route('original.route') // front-end dev will provide a route here.
                      ->with('error', 'Payment failed');
       */

        return $this->respondWithData([
            'status' => 'error',
            'data' => 'Payment failed'
        ]);
    }
}