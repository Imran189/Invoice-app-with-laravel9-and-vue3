<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get_invoice_list',[InvoiceController::class, 'get_invoice_list']);
Route::get('/search_invoice',[InvoiceController::class, 'search_invoice']);
Route::get('/create_invoice',[InvoiceController::class, 'create_invoice']);
Route::get('/all_customers',[CustomerController::class, 'all_customers']);
Route::get('/get_all_product',[ProductController::class,'get_all_product']);
