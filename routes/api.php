<?php

use App\Http\Controllers\Api\V1\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(callback: function(){
    Route::get(uri:'/users', action:[UserController::class, 'index']);
    Route::get('/users/{user}', action:[UserController::class, 'show']);
    Route::apiResource('invoices', InvoiceController::class);
    // Route::get(uri:'/invoices', action:[InvoiceController::class, 'index']);
    // Route::get('/invoices/{invoice}', action:[InvoiceController::class, 'show']);
    // Route::post('/invoices', action:[InvoiceController::class, 'store']);
    // Route::put('/invoices/{invoice}', action:[InvoiceController::class, 'update']);
    // Route::delete('/invoices/{invoice}', action:[InvoiceController::class, 'destroy']);
});


