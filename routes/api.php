<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



































Route::resource('buyers','Buyer\BuyerController',['only'=>['index','show']]);    

Route::resource('buyers/{buyer_id}/transactions','Buyer\BuyerTransactionController',['only'=>['index']]);  
Route::resource('buyers/{buyer_id}/products','Buyer\BuyerProductController',['only'=>['index']]);
Route::resource('buyers/{buyer_id}/sellers','Buyer\BuyerSellerController',['only'=>['index']]);
Route::resource('buyers/{buyer_id}/categories','Buyer\BuyerCategoryController',['only'=>['index']]);




Route::resource('categories','Category\CategoryController',['except'=>['create','edit']]);
Route::resource('categories/{category_id}/products','Category\CategoryProductController',['only'=>['index']]);
Route::resource('categories/{category_id}/sellers','Category\CategorySellerController',['only'=>['index']]);
Route::resource('categories/{category_id}/transactions','Category\CategoryTransactionController',['only'=>['index']]);
Route::resource('categories/{category_id}/buyers','Category\CategoryBuyerController',['only'=>['index']]);


Route::resource('products','Product\ProductController',['only'=>['index','show']]);    
Route::resource('products/{product_id}/transactions','Product\ProductTransactionController',['only'=>['index']]);
Route::resource('products/{product_id}/buyers','Product\ProductBuyerController',['only'=>['index']]);
Route::resource('products/{product_id}/categories','Product\ProductCategoryController');
Route::resource('products/{product_id}/buyers/{buyer_id}/transactions','Product\ProductBuyerTransactionController',['only'=>['store']]);



Route::resource('sellers','Seller\SellerController',['only'=>['index','show']]); 
Route::resource('sellers/{seller_id}/transactions','Seller\SellerTransactionController',['only'=>['index']]);
Route::resource('sellers/{seller_id}/categories','Seller\SellerCategoryController',['only'=>['index']]);
Route::resource('sellers/{seller_id}/buyers','Seller\SellerBuyerController',['only'=>['index']]);
Route::resource('sellers/{seller_id}/products','Seller\SellerProductController',['except'=>['create','show','edit']]);



Route::resource('transactions','Transaction\TransactionController',['only'=>['index','show']]);   

Route::resource('transactions/{transaction_id}/categories','Transaction\TransactionCategoryController',['only'=>['index']]);            


Route::resource('users','User\UserController',['except'=>['create','edit']]);           

//rem