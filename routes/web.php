<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;

Route::get('/', function () {
    return view('welcome');
});

Route::apiResource('users', UserController::class);
Route::apiResource('patients', PatientController::class);
Route::apiResource('doctors', DoctorController::class);
Route::apiResource('appointments', AppointmentController::class);
