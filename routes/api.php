<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobPostController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');


Route::post('{entity}/login', [AuthController::class, 'login'])
    ->whereIn('entity', ['company', 'candidate']);

Route::resource('jobs', JobPostController::class)
    ->middleware('auth:company');
