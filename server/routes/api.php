<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserActivityController;
use App\Http\Controllers\Auth\TokenController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [TokenController::class, 'login']);

// auth middleware
Route::middleware('auth:sanctum')->group(function () {

    // get quiz questions
    Route::get('/quiz/{quiz}', [QuizController::class, 'get']);
    
    // store users anserws
    Route::post('/activity/{quiz}', [UserActivityController::class, 'save']);
    
    // get users anserws
    Route::get('/activity/{quiz}', [UserActivityController::class, 'get']);

});
