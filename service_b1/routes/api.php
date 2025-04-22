<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Routes in this file are automatically prefixed with /api
| Example: Route::get('/orders') becomes /api/orders
|--------------------------------------------------------------------------
*/

// ✅ Test route to make sure API is working
Route::get('/debug', function () {
    return response()->json(['message' => 'API is alive!']);
});

// 🛒 Order-related endpoints
Route::get('/orders', [OrderController::class, 'index']);                 // List all orders
Route::get('/orders/{id}', [OrderController::class, 'show']);            // Show specific order by ID
Route::get('/users/{user_id}/orders', [OrderController::class, 'userOrders']); // List orders by user

Route::post('/orders', [OrderController::class, 'store']);               // Create new order
Route::put('/orders/{id}', [OrderController::class, 'update']);          // Update order status
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);      // Delete an order

// 👤 Optional: get current authenticated user info (if using Sanctum or Passport)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
