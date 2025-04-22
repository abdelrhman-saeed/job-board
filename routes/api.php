<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, JobApplicationController, JobPostController};
use App\Models\JobApplication;

Route::post('{entity}/login', [AuthController::class, 'login'])
    ->whereIn('entity', ['company', 'candidate']);

Route::resource('jobs', JobPostController::class);

Route::post('jobs/{job}/apply', [JobApplicationController::class,'apply'])
    ->middleware('auth:candidate');

Route::get('candidate/jobs', [JobApplicationController::class, 'getAppliedJobs'])
    ->middleware('auth:candidate');