<?php

use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Rotas de autenticação (públicas)
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Rotas protegidas - requerem autenticação
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Movie API routes protegidas
    Route::post('/movies', [MovieController::class, 'store']);
    Route::delete('/movies/{id}', [MovieController::class, 'destroy']);
    
    // Comment API routes protegidas
    Route::post('/comments', [CommentController::class, 'store']);
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);
    
    // Admin - Gestão de comentários pendentes
    Route::get('/comments/pending', [CommentController::class, 'pending']);
    Route::post('/comments/{id}/approve', [CommentController::class, 'approve']);
    Route::post('/comments/{id}/reject', [CommentController::class, 'reject']);
});

// Genre API routes (públicas)
Route::get('/genres', [GenreController::class, 'index']);

// Movie API routes (públicas)
Route::get('/movies/search', [MovieController::class, 'search']);
Route::get('/movies', [MovieController::class, 'index']);
Route::get('/movies/{id}', [MovieController::class, 'show']);

// Comment API routes (públicas)
Route::get('/comments/approved/{movieId}', [CommentController::class, 'approved']);

