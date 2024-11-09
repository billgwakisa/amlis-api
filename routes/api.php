<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TransactionsController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::get('user', 'PassportController@details');

Route::resource('merchants', 'MerchantsController');

Route::resource('transactions', TransactionsController::class);

Route::post('new-transaction', 'TransactionsController@newTransaction');

Route::get('merchant-transactions/{id}', 'TransactionsController@merchantTransactions');

Route::get('transactions-by-hour', 'TransactionsController@statsByHour');

Route::get('transactions-by-device', 'TransactionsController@statsByDevice');

Route::resource('customers', 'UserAccountsController');