<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/','FrontController@index')->name('home');
Route::get('/shirts','FrontController@shirts')->name('shirts');
Route::get('/shirt','FrontController@shirt')->name('shirt');
Route::get('/logout', 'Auth\LoginController@logout');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/cart','CartController');
Route::get('/cart/add-item/{id}','CartController@addItem')->name('cart.addItem');

Route::group(['prefix'=>'admin','middleware'=>['auth','admin']],function(){   // yeta prefix'=>'admin halyo bhane yo grp vitra ko route agadi automatic /admin/ add huncha 
	
	Route::get('/',function(){
		return view('admin.index');
	})->name('admin.index');

	Route::post('toggledeliver/{orderId}','OrderController@toggledeliver')->name('toggle.deliver');

	Route::get('orders/{type?}','OrderController@orders');

	Route::resource('product','ProductsController');
	Route::resource('category','CategoriesController');
});

Route::resource('address','AddressController');
//Route::get('checkout','CheckoutController@step1');

Route::group(['middleware' => 'auth'], function () {
    Route::get('shipping-info','CheckoutController@shipping')->name('checkout.shipping');
});

Route::get('payment','CheckoutController@payment')->name('checkout.payment');
Route::post('store-payment','CheckoutController@storePayment')->name('payment.store');


