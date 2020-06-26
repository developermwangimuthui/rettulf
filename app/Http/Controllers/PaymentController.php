<?php

namespace App\Http\Controllers;

use App\Music;
use Illuminate\Http\Request;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use Illuminate\Session\Store;
use Session;
use App\TemporaryTransaction;
use Auth;
use App\PaypalPayment;
class PaymentController extends Controller
{
    //

    public function upload_payment($id)
    {
        session()->put('music_id', $id);
        // $clientIP = request()->ip();


        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'Ab576qDQ2pShVNyKJms7tcBoxaq_xofpmJq2vBpMWLS2jfRkwnyzHB7QO6yH12gbQQa7OU_NJudN6n4z', // ClientID
                'EDCYQBhWefKcjvS_N26czclv5CzZTC9eF9CGsedOexQDb3K5Hd-M9YtomRosuNFuqfUbry5t-r2HP7gA' // ClientSecret
            )
        );
        // dd($apiContext) ;

        $number_of_days = 1;
        $price = 3;
        $subtotal  = $number_of_days * $price;
        $total = $subtotal + 0;


        $payer = new Payer();
        $payer->setPaymentMethod("paypal");
        $item1 = new Item();
        $item1->setName('Premium Package')
            ->setCurrency('USD')
            ->setQuantity($number_of_days)
            ->setSku("123123") // Similar to `item_number` in Classic API
            ->setPrice($price);
        // dd($payer) ;


        $itemList = new ItemList();
        $itemList->setItems(array($item1));

        $details = new Details();
        $details->setShipping(0.0)
            ->setTax(0.0)
            ->setSubtotal($subtotal);

        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($total)
            ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Payment description")
            ->setInvoiceNumber(uniqid());

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl("http://localhost:8000/execute_payment")
            ->setCancelUrl("http://localhost:8000");

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));

        $payment->create($apiContext);
        // dd($payment) ;

        $approvalUrl = $payment->getApprovalLink();
        // dd($approvalUrl) ;

        return redirect($approvalUrl);
    }

    public function execute_payment(Request $request)
    {
        $music_id = session()->get('music_id');


        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'Ab576qDQ2pShVNyKJms7tcBoxaq_xofpmJq2vBpMWLS2jfRkwnyzHB7QO6yH12gbQQa7OU_NJudN6n4z', // ClientID
                'EDCYQBhWefKcjvS_N26czclv5CzZTC9eF9CGsedOexQDb3K5Hd-M9YtomRosuNFuqfUbry5t-r2HP7gA' // ClientSecret
            )
        );

        $our_amount = 3;
        //  return request('transactions');
        $paymentId = request('paymentId');

        $payment = Payment::get($paymentId, $apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId(request('PayerID'));

        $transaction = new Transaction();
        $amount = new Amount();
        $details = new Details();

        $details->setShipping(0.0)
            ->setTax(0.0)
            ->setSubtotal($our_amount);

        $amount->setCurrency('USD');
        $amount->setTotal($our_amount);
        $amount->setDetails($details);
        $transaction->setAmount($amount);

        $execution->addTransaction($transaction);

        $result = $payment->execute($execution, $apiContext);
        $music_id = session()->get('music_id');

        $payment_id = request('paymentId');
        $PayerID = request('PayerID');
        $storage = $this->uploadedMusic($music_id,$payment_id,$PayerID);

        $request->session()->flush();
        return redirect()->route('myMusic');
    }
    public function uploadedMusic($music_id,$payment_id,$PayerID)
    {
        
  $user_id = Auth::user()->id;
        // dd($music_id) ;
        Music::where('id', $music_id)->update([
            'is_paid' => 1,
        ]);
        $payment = new PaypalPayment();
        $payment->paypal_id= $payment_id;
        $payment->payer_id= $PayerID;
        $payment->music_id= $music_id;
        $payment->payment_type= 'uploadedMusic';
        $payment->user_id= $user_id;
        $payment->save();
    }
    public function downloadedMusic()
    {
        // dd($music_id) ;
        $downloads = Music::where('id', $id)->pluck('downloads')->first();
        $new_downloads = $downloads + 1;

        Music::where('id', $music_id)->update([
            'is_paid' => 1,
            'downloads' => 1
        ]);
    }
}


http://localhost:8000/execute_payment?paymentId=PAYID-L327CJQ3CJ40814LB714084H&token=EC-43W05223TX4025028&PayerID=ZGMYFNRFDHSB8