<?php

use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\GenreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Genre API routes
Route::get('/genres', [GenreController::class, 'index']); // Listar todos os géneros

// Movie API routes
Route::get('/movies/search', [MovieController::class, 'search'])->middleware('web');
Route::get('/movies', [MovieController::class, 'index']);
Route::post('/movies', [MovieController::class, 'store']);
Route::get('/movies/{id}', [MovieController::class, 'show']);
Route::delete('/movies/{id}', [MovieController::class, 'destroy']);

// Comment API routes (públicas - não precisam autenticação)
Route::get('/comments/approved/{movieId}', [CommentController::class, 'approved']);
