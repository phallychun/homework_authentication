<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\PostController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Public Route User
// Public user register or register account
Route::post('register',[UserController::class, 'register']);

//user login
Route::post('login',[UserController::class, 'login']);

Route::get('users',[UserController::class, 'index']);
Route::get('users/{id}',[UserController::class, 'show']);

// Post
// Public Route
Route::get('/posts',[PostController::class, 'index']);
Route::get('/posts/{id}',[PostController::class, 'show']);

//Private Route Of post and user
Route::group(['middleware' => ['auth:sanctum']], function(){
    // Post
    Route::post('/posts',[PostController::class, 'store']);
    Route::put('/posts/{id}',[PostController::class, 'update']);
    Route::delete('/posts/{id}',[PostController::class, 'destroy']);

    // User logout
    Route::post('logout',[UserController::class, 'logout']);

});



