<?php

use App\Http\Controllers\TodosController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserTodosController;

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
// Protected Routes : User needs to be authenticated
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

    Route::get('/user', [UserController::class, 'getCurrentUser']);

    // =============================
    // User Specific Todos Routes
    Route::get('/user/todos', [UserTodosController::class, 'index']);

    Route::get('/user/todos/{id}', [UserTodosController::class, 'show']);

    Route::get('/user/todos/search/{name}', [UserTodosController::class, 'search']);

    Route::post('/user/todos', [UserTodosController::class, 'store']);

    Route::put('/user/todos/{id}', [UserTodosController::class, 'update']);

    Route::delete('/user/todos/{id}', [UserTodosController::class, 'destroy']);

});

// =====================================================================
// Admin Routes : 
// =====================================================================

// Protected : User needs to be authenticated and must be an Admin user
Route::group(['middleware' => ['auth:sanctum', 'isadmin']], function (){

    // User Access Routes
    Route::get('/users', [AdminController::class, 'getUsers']);

    Route::get('/users/{id}', [AdminController::class, 'getOneUser']);

    Route::post('/users', [AdminController::class, 'createUser']);

    Route::put('/users/{id}', [AdminController::class, 'updateUser']);

    Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);

    Route::get('/users/search/{name}', [AdminController::class, 'searchUsers']);

    // ==========================================================================
    // Admin Routes
    Route::post('/admins', [AdminController::class, 'createAdmin']);

    Route::post('/admins/logout', [AdminController::class, 'adminlogout']);

});

// Unprotected : No authentification needed
Route::post('/admins/login', [AdminController::class, 'adminlogin']);





