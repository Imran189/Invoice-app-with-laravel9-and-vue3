<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get_invoice_list',[InvoiceController::class, 'get_invoice_list']);
Route::get('/search_invoice',[InvoiceController::class, 'search_invoice']);
Route::get('/create_invoice',[InvoiceController::class, 'create_invoice']);
