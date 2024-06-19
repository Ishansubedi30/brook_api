<?php

use App\Http\Controllers\ReaderController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AnalyticsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Readers routes
Route::get('/readers', [ReaderController::class, 'index']);
Route::post('/readers', [ReaderController::class, 'store']);
Route::get('/readers/{id}', [ReaderController::class, 'show']);
Route::put('/readers/{id}', [ReaderController::class, 'update']);
Route::delete('/readers/{id}', [ReaderController::class, 'destroy']);

// Books routes
Route::get('/books', [BookController::class, 'index']);
Route::post('/books', [BookController::class, 'store']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::put('/books/{id}', [BookController::class, 'update']);
Route::delete('/books/{id}', [BookController::class, 'destroy']);

// Analytics routes
Route::get('/analytics', [AnalyticsController::class, 'index']);
Route::post('/analytics', [AnalyticsController::class, 'store']);
Route::get('/analytics/{id}', [AnalyticsController::class, 'show']);
Route::put('/analytics/{id}', [AnalyticsController::class, 'update']);
Route::delete('/analytics/{id}', [AnalyticsController::class, 'destroy']);
