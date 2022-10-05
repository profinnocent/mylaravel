<?php

use App\Http\Controllers\TodosController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

// ========================================================
// Public Routes
// =========================================================

    // User public Routes
    Route::post('/register', [UserController::class, 'register']);

    Route::post('/login', [UserController::class, 'login']);

    // Todos Public Routes
    Route::get('/todos', [TodosController::class, 'index']);

    Route::get('/todos/{id}', [TodosController::class, 'show']);

    Route::get('/todos/search/{name}', [TodosController::class, 'search']);

    // Tours Public Routes
    Route::get('/tours', [ToursController::class, 'index']);

    Route::get('/tours/{id}', [ToursController::class, 'show']);

    Route::get('/tours/search/{name}', [ToursController::class, 'search']);

// ========================================================
// Protected Routes
// =========================================================
    Route::group(['middleware' => ['auth:sanctum']], function(){

    Route::post('/logout', [UserController::class, 'logout']);

    // Todos Routes
    Route::post('/todos', [TodosController::class, 'store']);

    Route::put('/todos/{id}', [TodosController::class, 'update']);

    Route::delete('/todos/{id}', [TodosController::class, 'destroy']);

    // Tours Routes
    Route::post('/tours', [ToursController::class, 'store']);

    Route::put('/tours/{id}', [ToursController::class, 'update']);

    Route::delete('/tours/{id}', [ToursController::class, 'destroy']);

});



Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'getUser']);
