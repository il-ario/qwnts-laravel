<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/** 
 * App\Http\Middleware\ForceJsonResponse
 */
Route::group(['middleware' => ['json.response']], function () {
    /**
     * Login endpoint
     */
    Route::post('/login', [AuthController::class, 'login']);
    
    /**
     * Protected routes
     */
    Route::middleware('auth:api')->group(function () {
        /**
         * Logout endpoint
         */
        Route::post('/logout', [AuthController::class, 'logout']);
    
        /**
         * User endpoints
         */
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::get('/users/{email}', [UserController::class, 'show']);
        Route::put('/users/{email}', [UserController::class, 'update']);
        Route::delete('/users/{email}', [UserController::class, 'destroy']);
    
        /**
         * Address endpoints
         */
        Route::get('/addresses', [AddressController::class, 'index']);
        Route::post('/addresses', [AddressController::class, 'store']);
        
        /**
         * Post endpoints
         */
        Route::get('/posts', [PostController::class, 'index']);
        Route::post('/posts', [PostController::class, 'store']);
        Route::get('/posts/{id}', [PostController::class, 'show']);
        Route::put('/posts/{id}', [PostController::class, 'update']);
        
        /**
         * Comment endpoints
         */
        Route::get('/posts/{id}/comments', [CommentController::class, 'index']);
        Route::post('/posts/{id}/comments', [CommentController::class, 'store']);
    });
});

