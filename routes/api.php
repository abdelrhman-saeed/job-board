<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


Route::post('{entity}/login', [AuthController::class, 'login'])
    ->whereIn('entity', ['company', 'candidate']);
