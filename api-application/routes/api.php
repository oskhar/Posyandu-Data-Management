<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DrafSuratController;
use App\Http\Controllers\EdukasiController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\FormatAController;
use App\Http\Controllers\FormatBAController;
use App\Http\Controllers\FormatCController;
use App\Http\Controllers\FormatDController;
use App\Http\Controllers\GambarController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\PosyanduController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\StatistikController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\TantanganController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WilayahController;
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

/**
 * Endpoint public
 *
 */
Route::post('/login', [AuthController::class, 'login']);

Route::post('/user/login', [AuthUserController::class, 'login']);
Route::post('/user/register', [AuthUserController::class, 'register']);

Route::get('/resleting/tantangan', [TantanganController::class, 'get']);
Route::get('/resleting/tantangan/{id}', [TantanganController::class, 'getSpesific']);

Route::get('/produk', [ProdukController::class, 'get']);
Route::get('/produk/pin', [ProdukController::class, 'pin']);
Route::get('/produk/tags', [ProdukController::class, 'tags']);
Route::get('/produk/{id}', [ProdukController::class, 'getSpesific']);

Route::get('/format-ba', [FormatBAController::class, 'get']);

Route::get('/edukasi', [EdukasiController::class, 'get']);
Route::get('/jumlah-bayi', [FormatAController::class, 'jumlah_bayi']);
Route::get('/berita', [BeritaController::class, 'get']);
Route::get('/gambar', [GambarController::class, 'get']);
Route::get('/posyandu', [PosyanduController::class, 'get']);
Route::get('/jabatan', [AdminController::class, 'jabatan']);
Route::get('/struktur-admin', [AdminController::class, 'strukturAdmin']);
Route::get('/listtahun', [FormatBAController::class, 'getListTahun']);

/**
 * API Wilayah Indonesia
 *
 */
Route::prefix('indonesia')->group(function () {

    Route::get('/provinces', [WilayahController::class, 'provinces']);
    Route::get('/regencies', [WilayahController::class, 'regencies']);
    Route::get('/districts', [WilayahController::class, 'districts']);
    Route::get('/villages', [WilayahController::class, 'villages']);

});

/**
 * Endpoint privat Bearer protected user
 *
 */
Route::group(['middleware' => ['auth:sanctum', 'checkUserType:user']], function ($router) {
    /**
     * Endpoint untuk autentikasi user
     *
     */
    Route::post('/user/auth', [AuthUserController::class, 'authData']);
    Route::post('/user/logout', [AuthUserController::class, 'logout']);
    Route::put('/user', [AuthUserController::class, 'put']);
    Route::put('/user/reset-password', [AuthUserController::class, 'resetPassword']);

    Route::post('/resleting/submission', [SubmissionController::class, 'post']);
    Route::delete('/resleting/submission/{id}', [SubmissionController::class, 'delete']);

    Route::get('/user/tantangan', [TantanganController::class, 'user']);
});

/**
 * Endpoint privat Bearer protected admin
 *
 */
Route::group(['middleware' => ['auth:sanctum', 'checkUserType:admin']], function ($router) {

    /**
     * Endpoint untuk autentikasi
     *
     */
    Route::post('/auth', [AuthController::class, 'authData']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/reset-password', [AuthController::class, 'resetPassword']);

    /**
     * Endpoint untuk user
     *
     */
    Route::get('/user', [UserController::class, 'get']);
    Route::delete('/user', [UserController::class, 'delete']);

    /**
     * Endpoint untuk edukasi
     *
     */
    Route::post('/edukasi', [EdukasiController::class, 'post']);
    Route::put('/edukasi', [EdukasiController::class, 'put']);
    Route::delete('/edukasi', [EdukasiController::class, 'delete']);

    /**
     * Endpoint untuk berita
     *
     */
    Route::post('/berita', [BeritaController::class, 'post']);
    Route::put('/berita', [BeritaController::class, 'put']);
    Route::delete('/berita', [BeritaController::class, 'delete']);

    /**
     * Endpoint untuk gambar
     *
     */
    Route::post('/gambar', [GambarController::class, 'post']);
    Route::delete('/gambar', [GambarController::class, 'delete']);

    /**
     * Endpoint untuk posyandu
     *
     */
    Route::put('/posyandu', [PosyanduController::class, 'put']);

    /**
     * Endpoint untuk admin
     *
     */
    Route::get('/admin', [AdminController::class, 'get']);
    Route::post('/admin', [AdminController::class, 'post']);
    Route::put('/admin', [AdminController::class, 'put']);
    Route::delete('/admin', [AdminController::class, 'delete']);

    /**
     * Endpoint untuk format-a
     *
     */
    Route::get('/format-a', [FormatAController::class, 'get']);
    Route::post('/format-a', [FormatAController::class, 'post']);
    Route::put('/format-a', [FormatAController::class, 'put']);
    Route::delete('/format-a', [FormatAController::class, 'delete']);
    Route::get('/list-orang-tua', [FormatAController::class, 'listOrangTua']);

    /**
     * Endpoint untuk format-b
     *
     */
    Route::post('/format-ba', [FormatBAController::class, 'post']);
    Route::put('/format-ba', [FormatBAController::class, 'put']);
    Route::delete('/format-ba', [FormatBAController::class, 'delete']);

    /**
     * Endpoint untuk format-c
     *
     */
    Route::get('/format-c', [FormatCController::class, 'get']);
    Route::post('/format-c', [FormatCController::class, 'post']);
    Route::put('/format-c', [FormatCController::class, 'put']);
    Route::delete('/format-c', [FormatCController::class, 'delete']);

    /**
     * Endpoint untuk format-d
     *
     */
    Route::get('/format-d', [FormatDController::class, 'get']);
    Route::post('/format-d', [FormatDController::class, 'post']);
    Route::put('/format-d', [FormatDController::class, 'put']);
    Route::delete('/format-d', [FormatDController::class, 'delete']);

    /**
     * Endpoint untuk export file excel
     *
     */
    Route::prefix('export')->group(function () {

        Route::get('/format-a', [ExportController::class, 'exportFormatAExcel']);
        Route::get('/format-b', [ExportController::class, 'exportFormatBAExcel']);
        Route::get('/format-c', [ExportController::class, 'exportFormatCExcel']);
        Route::get('/laporan-b', [ExportController::class, 'exportLaporanBAExcel']);

    });

    /**
     * Endpoint untuk import file excel
     *
     */
    Route::prefix('import')->group(function () {

        Route::post('/format-a', [ImportController::class, 'importFormatAExcel']);
        Route::post('/format-b', [ImportController::class, 'importFormatBExcel']);
        Route::post('/format-c', [ImportController::class, 'formatCImport']);

    });

    /**
     * Endpoint untuk mendapatkan data statistik
     *
     */
    Route::prefix('statistik')->group(function () {

        Route::get('/dashboard', [StatistikController::class, 'dashboard']);

    });

    /**
     * Endpoint untuk kader gendong
     *
     */
    Route::prefix('kader-gendong')->group(function () {

        Route::get('/', [SuratController::class, 'get']);
        Route::post('/', [SuratController::class, 'post']);
        Route::post('/preview', [SuratController::class, 'preview']);
        Route::get('/draf', [DrafSuratController::class, 'get']);
        Route::post('/draf', [DrafSuratController::class, 'post']);
        Route::post('/draf/cetak/{id}', [DrafSuratController::class, 'draftToSurat']);
        Route::put('/draf/{id}', [DrafSuratController::class, 'put']);
        Route::delete('/draf/{id}', [DrafSuratController::class, 'delete']);
        Route::get('/{id}', [SuratController::class, 'show']);

    });

    /**
     * Endpoint untuk resleting
     *
     */
    Route::prefix('resleting')->group(function () {

        Route::post('/tantangan', [TantanganController::class, 'post']);
        Route::put('/tantangan/{id}', [TantanganController::class, 'put']);
        Route::delete('/tantangan/{id}', [TantanganController::class, 'delete']);

        Route::get('/submission', [SubmissionController::class, 'get']);
        Route::put('/submission/{id}', [SubmissionController::class, 'put']);

    });

    /**
     * Endpoint untuk produk
     *
     */
    Route::post('/produk', [ProdukController::class, 'post']);
    Route::put('/produk/{id}', [ProdukController::class, 'put']);
    Route::delete('/produk/{id}', [ProdukController::class, 'delete']);
});

/**
 * API Testing
 *
 */
Route::get('/testing', [FormatBAController::class, 'apiTesting']);
