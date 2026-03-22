<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Autenticación (públicas)
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas
Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    //Rutas solo de admin - gestionan ususarios
    Route::middleware(['role:admin'])->group(function () {
        //Rutas aqui
    });

    //Rutas de admin y asistente - crear pacientes y expedientes
    Route::middleware(['role:admin|asistente'])->group(function () {
        //Rutas aqui
    });

    //Rutas de admin, médico y asistente - citas
    Route::middleware(['role:admin|medico|asistente'])->group(function () {
        Route::post('/appointments', [AppointmentController::class, 'store']);
    });

    //Rutas de admin y medico - editar expedientes
    Route::middleware(['role:admin|medico'])->group(function () {
        //Rutas aqui
    });

});