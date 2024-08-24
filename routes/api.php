<?php

use App\Http\Controllers\Api\ReaderController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\AnalyticsController;
use App\Http\Controllers\Api\BookFileController;
use Illuminate\Support\Facades\Route;

Route::apiResource('books',BookController::class);

Route::get('/user', function(Request $request){
    return $request->user();
})->middleware('auth:sanctum');

// Admins routes
Route::get('/admins', [AdminController::class, 'index']);
Route::post('/admins', [AdminController::class, 'store']);
Route::get('/admins/{id}', [AdminController::class, 'show']);
Route::put('/admins/{id}', [AdminController::class, 'update']);
Route::delete('/admins/{id}', [AdminController::class, 'destroy']);

// Readers routes
Route::get('/readers', [ReaderController::class, 'index']);
Route::post('/readers', [ReaderController::class, 'store']);
Route::get('/readers/{id}', [ReaderController::class, 'show']);
Route::put('/readers/{id}', [ReaderController::class, 'update']);
Route::delete('/readers/{id}', [ReaderController::class, 'destroy']);
Route::post('/login', [ReaderController::class, 'login']);


// Books routes
Route::get('/books', [BookController::class, 'index']);
Route::post('/books', [BookController::class, 'store']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::put('/books/{id}', [BookController::class, 'update']);
Route::delete('/books/{id}', [BookController::class, 'destroy']);

// Book File routes
Route::get('/bookfiles', [BookFileController::class, 'index']);
Route::post('/bookfiles', [BookFileController::class, 'store']);
Route::get('/bookfiles/{id}', [BookFileController::class, 'show']);
Route::put('/bookfiles/{id}', [BookFileController::class, 'update']);
Route::delete('/bookfiles/{id}', [BookFileController::class, 'destroy']);

// Analytics routes
Route::get('/analytics', [AnalyticsController::class, 'index']);
Route::post('/analytics', [AnalyticsController::class, 'store']);
Route::get('/analytics/{id}', [AnalyticsController::class, 'show']);
Route::put('/analytics/{id}', [AnalyticsController::class, 'update']);
Route::delete('/analytics/{id}', [AnalyticsController::class, 'destroy']);


Route::middleware(['web'])->group(function () {
});