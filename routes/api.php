<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\IclockController;
use App\Http\Controllers\Api\UserController;

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

Route::resource('api-karyawan', App\Http\Controllers\Api\KaryawanController::class);
Route::resource('absensi', App\Http\Controllers\Api\AbsenController::class);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/users/update-profil', [UserController::class, 'updateProfil'])->name('user.update.profil');
Route::post('/users/change-password', [UserController::class, 'changePassword'])->name('user.change.password');

// handshake
Route::get('/iclock/cdata', [iclockController::class, 'handshake']);

Route::post('/iclock/cdata', [IclockController::class, 'receiveRecords']);
