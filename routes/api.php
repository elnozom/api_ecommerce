<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('cors:api')->group(function (){
    
Route::middleware('guest:api')->group(function () {
    Route::post('/login','AuthController@login');
	Route::post('/register','AuthController@register');
});

Route::middleware('auth:api')->group(function () {
	Route::prefix('user')->group(function () {
		Route::post('/phone','UserController@AddPhone');
		Route::get('/orders','UserController@GetOrders');
		Route::put('/phone/{id}','UserController@UpdatePhone');
		Route::delete('/phone/{id}','UserController@DeletePhone');
		Route::put('/','UserController@update');
		Route::get('/','UserController@get');
	});
	
	
	// Route::delete('/address/{id}/main','AddressController@setMain')->name('api.address.main');
    });
});
Route::post('/logout','AuthController@logout');
    Route::middleware('auth:api')->prefix('address')->group(function () {
		Route::post('/','AddressController@create');
		Route::put('/{id}','AddressController@update');
		Route::delete('/{id}','AddressController@delete');
		Route::get('/list','AddressController@list');
		Route::get('/find/{id}','AddressController@find');
	});
	Route::prefix('area')->group(function () {
		Route::post('/','AreaController@create');
		Route::put('/{id}','AreaController@update');
		Route::delete('/{id}','AreaController@delete');
		Route::get('/list','AreaController@list');
	});
	Route::prefix('group')->group(function () {
		Route::post('/','GroupController@create');
		Route::put('/{id}','GroupController@update');
		Route::put('/disable/{id}','GroupController@disable');
		Route::put('/enable/{id}','GroupController@enable');
		Route::delete('/{id}','GroupController@delete');
		Route::get('/find/{id}','GroupController@find');
		Route::get('/list','GroupController@list');
		Route::get('/two-layers','GroupController@listWithChildren');
    	Route::get('/three-layers','GroupController@listThreeLayers');
	});
	Route::prefix('product')->group(function () {
		Route::post('/','ProductController@create');
		Route::put('/{id}','ProductController@update');
		Route::delete('/{id}','ProductController@delete');
		Route::get('/find/{id}','ProductController@find');
		Route::get('/','ProductController@list');
	});

	Route::prefix('cart')->middleware('auth:api')->group(function(){
        Route::get('/','CartController@get');
        Route::post('/','CartController@create');
        Route::delete('/{id}','CartController@delete');
        Route::put('/{id}','CartController@update');
    	Route::post('/coupon','CartController@applyCoupon');
    	Route::put('/address/{id}','CartController@applyAddress');
    	Route::post('/checkout','CartController@checkout');
	// Route::delete('/decrease/{id}','CartController@DecreaseCartItem');
        
    });
	Route::prefix('wishlist')->middleware('auth:api')->group(function(){
        Route::get('/','WishlistController@get');
        Route::post('/','WishlistController@create');
        Route::delete('/{id}','WishlistController@delete');
	// Route::delete('/decrease/{id}','CartController@DecreaseCartItem');
        
    });