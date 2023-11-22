<?php

use App\Http\Controllers\BeritaController;
use App\Http\Controllers\EdukasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth:sanctum'], function ($router) {


});

Route::get('/edukasi', [EdukasiController::class, 'get']);
Route::post('/edukasi', [EdukasiController::class, 'post']);
Route::put('/edukasi', [EdukasiController::class, 'put']);
Route::delete('/edukasi', [EdukasiController::class, 'delete']);

Route::get('/berita', [BeritaController::class, 'get']);
Route::post('/berita', [BeritaController::class, 'post']);
Route::put('/berita', [BeritaController::class, 'put']);
Route::delete('/berita', [BeritaController::class, 'delete']);
