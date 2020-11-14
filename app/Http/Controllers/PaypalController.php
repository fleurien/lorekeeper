<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Notifications;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\Models\Invoice;
use App\Models\User\User;
use App\Models\Product;

use App\Http\Controllers\Controller;

class PaypalController extends Controller
{
    
    protected $provider;

    public function __construct() {
        $this->provider = new ExpressCheckout();
    }

    public function expressCheckout(Request $request) {
        // check if payment is recurring
        $recurring = $request->input('recurring', false) ? true : false;
        $item = $request->input('item');
        $request->session()->put('stock', $request->input('stock'));
        $request->session()->put('total', $request->input('total'));

        $price = $request->input('total');
        $stock = $request->input('stock');
        $check = Stock::find($stock);
        $user = Auth::user();

        // get new invoice id
        $invoice_id = Invoice::count() + 1;
            
        // Get the cart data
        $cart = $this->getCart($recurring, $price, $invoice_id);
        
        // create new invoice
        $invoice = new Invoice();
        $invoice->title = $cart['invoice_description'];
        $invoice->price = $cart['total'];
        $invoice->user_id = $user->id;
        $invoice->save();

        $options = [
            'BRANDNAME' => 'Site ARPG',
            'LOGOIMG' => '/',
            'CHANNELTYPE' => 'Merchant',
            'CATEGORY' => 'DIGITAL_GOODS',
        ];

        $response = $this->provider->addOptions($options)->setExpressCheckout($cart, $recurring);
        if (!$response['paypal_link']) {
          return redirect('/cash-shop')->with(['code' => 'danger', 'message' => 'Something went wrong with PayPal, please try again in a few minutes.']);
        }

        if($check != NULL) {
        if($check->quantity <= 0) { 
            return redirect('/cash-shop')->with(['code' => 'danger', 'message' => 'All these items have been bought']);
            }
        }
        return redirect($response['paypal_link']);
      }

      
      private function getCart($recurring, $price, $invoice_id) {

        if ($recurring) {
            return [
                // if payment is recurring cart needs only one item
                // with name, price and quantity
                'items' => [
                    [
                        'name' => 'Monthly Subscription ' . config('paypal.invoice_prefix') . ' #' . $invoice_id,
                        'price' => 20,
                        'qty' => 1,
                    ],
                ],

                // return url is the url where PayPal returns after user confirmed the payment
                'return_url' => url('/paypal/express-checkout-success?recurring=1'),
                'subscription_desc' => 'Monthly Subscription ' . config('paypal.invoice_prefix') . ' #' . $invoice_id,
                // every invoice id must be unique, else you'll get an error from paypal
                'invoice_id' => config('paypal.invoice_prefix') . 'Invoice-' . $invoice_id,
                'invoice_description' => "Order #". $invoice_id ." Invoice",
                'cancel_url' => url('/cash-shop'),
                // total is calculated by multiplying price with quantity of all cart items and then adding them up
                // in this case total is 20 because price is 20 and quantity is 1
                'total' => 20, // Total price of the cart
            ];
        }
            return [
                // if payment is not recurring cart can have many items
                // with name, price and quantity
                'items' => [
                    [
                        'name' => 'ARPG Item',
                        'price' => $price,
                        'qty' => 1,
                    ],
                ],

                // return url is the url where PayPal returns after user confirmed the payment
                'return_url' => url('/paypal/express-checkout-success'),
                // every invoice id must be unique, else you'll get an error from paypal
                'invoice_id' => config('paypal.invoice_prefix') . 'Invoice-' . $invoice_id,
                'invoice_description' => "ARPG Item purchase. Order #".$invoice_id." Invoice",
                'cancel_url' => url('/cash-shop'),
                // total is calculated by multiplying price with quantity of all cart items and then adding them up
                // in this case total is 20 because Product 1 costs 10 (price 10 * quantity 1) and Product 2 costs 10 (price 5 * quantity 2)
                'total' => $price,
            ];
    }

    public function expressCheckoutSuccess(Request $request) {

        // check if payment is recurring
        $recurring = $request->input('recurring', false) ? true : false;

        $token = $request->get('token');

        $PayerID = $request->get('PayerID');

        $price = session('total');

        $stock = session('stock');
        
        // initially we paypal redirects us back with a token
        // but doesn't provice us any additional data
        // so we use getExpressCheckoutDetails($token)
        // to get the payment details
        $response = $this->provider->getExpressCheckoutDetails($token);

        // if response ACK value is not SUCCESS or SUCCESSWITHWARNING
        // we return back with error
        if (!in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            return redirect('/cash-shop')->with(['code' => 'danger', 'message' => 'Error processing PayPal payment']);
        }

        // invoice id is stored in INVNUM
        // because we set our invoice to be xxxx_id
        // we need to explode the string and get the second element of array
        // which will be the id of the invoice
        $invoice_id = explode('Invoice-', $response['INVNUM'])[1];

        // get cart data
        $cart = $this->getCart($recurring, $price, $invoice_id);

        // check if our payment is recurring
        if ($recurring === true) {
            
            // if recurring then we need to create the subscription
            // you can create monthly or yearly subscriptions
            $response = $this->provider->createMonthlySubscription($response['TOKEN'], $response['AMT'], $cart['subscription_desc']);
            
            $status = 'Invalid';
            // if after creating the subscription paypal responds with activeprofile or pendingprofile
            // we are good to go and we can set the status to Processed, else status stays Invalid
            if (!empty($response['PROFILESTATUS']) && in_array($response['PROFILESTATUS'], ['ActiveProfile', 'PendingProfile'])) {
                $status = 'Processed';
            }

        } else {

            // if payment is not recurring just perform transaction on PayPal
            // and get the payment status
            $payment_status = $this->provider->doExpressCheckoutPayment($cart, $token, $PayerID);
            $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];

        }

        // find invoice by id
        $invoice = Invoice::find($invoice_id);

        // set invoice status
        $invoice->payment_status = $status;
        
        $user = Auth::user();
        $recipient = User::find($user->id);

                Notifications::create('PURCHASE', $recipient, [
                    'code' => $invoice_id,
                ]);

        // if payment is recurring lets set a recurring id for latter use
        if ($recurring === true) {
            $invoice->recurring_id = $response['PROFILEID'];
        }

        // save the invoice
        $invoice->save();

        // App\Invoice has a paid attribute that returns true or false based on payment status
        // so if paid is false return with error, else return with success message
        if ($invoice->paid) {
            //reduce stock by one
            if (!empty($stock)){
                $product = Stock::find($stock);
                $product->decrement('quantity');
                $product->save(); 
            }
            session()->forget(['stock', 'total']);
            
            return redirect('/paypal-success')->with(['code' => 'success', 'message' => 'Your order has been paid succesfully.']);
        }
        
        return redirect('/')->with(['code' => 'danger', 'message' => 'Error processing PayPal payment for Order ' . $invoice->id . '!']);
    }

    /*
    *
    *   Notifies merchant of a payment
    */
    public function notify(Request $request)
    {

        // add _notify-validate cmd to request,
        // we need that to validate with PayPal that it was realy
        // PayPal who sent the request
        $request->merge(['cmd' => '_notify-validate']);
        $post = $request->all();

        // send the data to PayPal for validation
        $response = (string) $this->provider->verifyIPN($post);

        //if PayPal responds with VERIFIED we are good to go
        if ($response === 'VERIFIED') {

            /**
            *    This is the part of the code where you can process recurring payments as you like
            *    in this case we will be checking for recurring_payment that was completed
            *    if we find that data we create new invoice
            */
            if ($post['txn_type'] == 'recurring_payment' && $post['payment_status'] == 'Completed') {
                $invoice = new Invoice();
                $invoice->title = 'Recurring payment';
                $invoice->price = $post['amount'];
                $invoice->payment_status = 'Completed';
                $invoice->recurring_id = $post['recurring_payment_id'];
                $invoice->save();
            }

            // I leave this code here so you can log IPN data if you want
            // PayPal provides a lot of IPN data that you should save in real world scenarios
                                  
                $logFile = 'ipn_log_'.Carbon::now()->format('Ymd_His').'.txt';
                Storage::disk('local')->put($logFile, print_r($post, true));
            
        }  
        
    }
}
        
    

