<?php

namespace App\Http\Controllers;

use \Stripe\Error\Card; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Order;

class CheckoutController extends Controller
{
    // public function step1()
    // {
    // 	if(Auth::check())
    // 	{
    // 		return redirect()->route('checkout.shipping');  //checkout.shipping is a route name definedin web.php which give url= /shipping-info
    // 	}
    // 	return redirect('login');
    // }

    public function shipping()
    {
    	return view('front.shipping-info');
    }

    public function payment()
    {
    	return view('front.payment');
    }

    public function storePayment(Request $request)
    {
    	// $user = Auth::user();
    	// dd($user);

        // Set your secret key: remember to change this to your live secret key in production
    	// See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey("sk_test_KsVCdilntrEbPOLXHH8gnzab");
		// Get the credit card details submitted by the form
		        $token = $request->stripeToken;
		        
		// Create a charge: this will charge the user's card
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => Cart::total()*100, // Amount in cents
                "currency" => "usd",
                "source" => $token,
                "description" => "Example charge"
            ));
        } catch (Card $e) {
            // The card has been declined
        }//untill here we charged our customer
      	
        //Create the order
       	Order::createOrder();
        //redirect user to some page
        return "Order completed";
    }
}
