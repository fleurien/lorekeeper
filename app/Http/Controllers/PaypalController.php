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
use App\Models\Item\Item;
use App\Services\InventoryManager;

use App\Http\Controllers\Controller;

class PaypalController extends Controller
{
    
    protected $provider;

    public function __construct() {
        $this->provider = new ExpressCheckout();
    }

    public function expressCheckout(Request $request) {
        // check if payment is recurring, have to do this to provide a parameter for paypal
        $recurring = $request->input('recurring', false) ? true : false;
        $item = $request->input('item');
        $amount = $request->input('amount');
        // stuff cause paypal is stupid
        $request->session()->put('stock', $request->input('stock'));
        $request->session()->put('total', $request->input('total'));
        $request->session()->put('item', $request->input('item'));
        $request->session()->put('amount', $request->input('amount'));

        $price = $request->input('amount') * $request->input('total');
        $stock = $request->input('stock');
        $check = Product::find($stock);
        $user = Auth::user();
        // get new invoice id
        $invoice_id = Invoice::count() + 1;
            
        // Get the cart data
        $cart = $this->getCart($recurring, $price, $amount, $invoice_id);
        
        // create new invoice
        $invoice = new Invoice();
        $invoice->id = $invoice_id;
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
        
        if($check->is_limited = 1) {
            if($amount > $check->quantity) return redirect('/cash-shop')->with(['code' => 'danger', 'message' => 'Cannot purchase more than remaining stock.']);
            }
    
            if($check != NULL) {
            if($check->quantity <= 0) { 
                return redirect('/cash-shop')->with(['code' => 'danger', 'message' => 'All these items have been bought']);
                }
            }

        $response = $this->provider->addOptions($options)->setExpressCheckout($cart, $recurring);
        if (!$response['paypal_link']) {
          return redirect('/cash-shop')->with(['code' => 'danger', 'message' => 'Something went wrong with PayPal, please try again in a few minutes.']);
        }

        return redirect($response['paypal_link']);
      }

      
      private function getCart($recurring, $price, $amount, $invoice_id) {

        if ($recurring) {
            // I leave this setup in case someone DOES want recurring but realistically this is useless
            return [
                'items' => [
                    [
                        'name' => 'Monthly Subscription ' . config('paypal.invoice_prefix') . ' #' . $invoice_id,
                        'price' => 20,
                        'qty' => 1,
                    ],
                ],
                'return_url' => url('/paypal/express-checkout-success?recurring=1'),
                'subscription_desc' => 'Monthly Subscription ' . config('paypal.invoice_prefix') . ' #' . $invoice_id,
                'invoice_id' => config('paypal.invoice_prefix') . 'Invoice-' . $invoice_id,
                'invoice_description' => "Order #". $invoice_id ." Invoice",
                'cancel_url' => url('/cash-shop'),
                'total' => 20, // Total price of the cart
            ];
        }
            return [
                'items' => [
                    [
                        'name' => 'ARPG Item',
                        'price' => $price,
                        'qty' => $amount,
                    ],
                ],
                'return_url' => url('/paypal/express-checkout-success'),
                'invoice_id' => config('paypal.invoice_prefix') . 'Invoice-' . $invoice_id,
                'invoice_description' => "ARPG Item purchase. Order #".$invoice_id." Invoice",
                'cancel_url' => url('/cash-shop'),
                'total' => $price,
            ];
    }

    public function expressCheckoutSuccess(Request $request, InventoryManager $service) {

        // this function is the completion fuction, user has been charged but more validation needed
        // check if payment is recurring
        $recurring = $request->input('recurring', false) ? true : false;

        $token = $request->get('token');

        $PayerID = $request->get('PayerID');

        $price = session('amount') * session('total');

        $stock = session('stock');

        $amount = session('amount');
        
        //get details
        $response = $this->provider->getExpressCheckoutDetails($token);

        if (!in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            return redirect('/cash-shop')->with(['code' => 'danger', 'message' => 'Error processing PayPal payment']);
        }

        $invoice_id = explode('Invoice-', $response['INVNUM'])[1];
        $cart = $this->getCart($recurring, $price, $amount, $invoice_id);

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
        $item_id = session('item');
        $item = Item::find( $item_id);

                Notifications::create('PURCHASE', $recipient, [
                    'item' => $item->name,
                ]);

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
                $product = Product::find($stock);
                $product->decrement('quantity', $amount);
                $product->save(); 
            }
            session()->forget(['stock', 'total']);
            $data = [];
            $data['data'] = 'Bought from cash store by ' . $user->name . ' for $' . $price;
            $data['notes'] = 'Bought from cash store';
            if($service->creditItem(null, $user, 'Cash Shop Purchase', $data, $item, $amount)) {
                flash('Items granted successfully.')->success();
            }
            else {
                foreach($service->errors()->getMessages()['error'] as $error) flash($error)->error();
            }
            
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

        // not used, may add in future
        
    }
}
        
    

