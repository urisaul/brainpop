<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\TokenController;
use Illuminate\Http\Request;

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

// get quiz questions
Route::get('/quiz', function (Request $request) {
    return \App\Models\Quiz::get();
});

// store users anserws
Route::post('/activity', [ActivityController::class, 'save']);

// get users anserws
Route::get('/activity', [ActivityController::class, 'get']);
