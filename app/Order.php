<?php

namespace App;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    protected $fillable=['total','delivered'];

    public function orderItems()
    {
    	return $this->belongsToMany(Product::class)->withPivot('qty','total')->withTimestamps();;
    }

    public static function createOrder()
    {

      	$user = Auth::user();
      	$order = $user->orders()->create([          //order->user_id,delivered,total
      		'total' => Cart::total(),
      		'delivered' =>0,
      	]);

      	$cartItems=Cart::content();
        foreach ($cartItems as $cartItem)
      	{
      		$order->orderItems()->attach($cartItem->id,[      //$cartItem->id is the id of product
      			'qty' => $cartItem->qty,
      			'total' => $cartItem->qty*$cartItem->price
      		]);
      	}//insert items of cart into order_product table
      	
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
