<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\User;

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

//api for admin dashboard like create,edit and delete
Route::controller(UserController::class)->group(function () {
    Route::get('admin', 'index');
    Route::post('login', 'login');
});

// api defined for invoice
Route::controller(InvoiceController::class)->group(function () {
    Route::get('invoices', 'index');
    Route::get('invoice/{id}', 'singleInvoice');
    Route::delete('invoice/{id}', 'destroy');
    // Route::post('invoice/create', 'create');
    Route::post('customers/{customerId}/invoices', 'store');
    Route::get('invoiceItem/{invoiceId}', 'getInvoiceItems');
    Route::get('customers/{customerId}/invoices', 'getInvoicesForCustomer');
    Route::get('totalRevenue','getTotalRevenue');
    Route::get('totalOrder','getTotalInvoicesForCurrentMonth');
});

// api defined for invoice
Route::controller(CustomerController::class)->group(function () {
    Route::get('customers', 'index');
    Route::get('customer/count', 'count');
});

// api defined for product
Route::controller(ProductController::class)->group(function () {
    Route::get('products', 'index');
    Route::get('product/{id}', 'singleProduct');
    Route::delete('product/{id}', 'destroy');
    Route::post('product/create', 'create');
    Route::get('totalCount/product', 'indexCount');

});
