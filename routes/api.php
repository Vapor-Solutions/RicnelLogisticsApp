<?php

use App\Models\Invoice;
use App\Models\ProductItem;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/{id}/product_item',function($id){
    return ProductItem::find($id);
});
Route::get('/{id}/invoice',function($id){
    return Invoice::find($id)->productDescriptions();
});
Route::get('/{id}/sale',function($id){
    return Sale::find($id)->productDescriptions();
});

