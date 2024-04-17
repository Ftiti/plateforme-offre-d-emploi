<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\JobApplicationController;


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
// api.php
Route::get('job-applications-list', [JobApplicationController::class, 'list']);
Route::post('job-applications', [JobApplicationController::class, 'store']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/verify-code', [UserController::class, 'verify']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/profile', [UserController::class, 'profile']);
Route::apiResource('job-offers', JobOfferController::class);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



