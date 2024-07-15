<?php

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\LaporanAbsenController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\LaporanPenggajianController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\ProductCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth');


Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
Route::get('/dashboard', 'App\Http\Controllers\HomeController@index')->name('dashboard')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});


Route::resource('administrator', AdministratorController::class);
Route::resource('karyawan', KaryawanController::class)->middleware('auth');
Route::resource('penggajian', PenggajianController::class)->middleware('auth');
Route::resource('product', ProductController::class)->except(['show'])->middleware('auth');
Route::get('my-asset', [ProductController::class, 'myAsset'])->middleware('auth');
Route::get('product/accurate', [ProductController::class, 'getAccurate'])->middleware('auth');
Route::resource('transaction', TransactionController::class)->except(['show'])->middleware('auth');
Route::post('transaction/approve', [TransactionController::class, 'approve'])->name('transaction.approve')->middleware('auth');
Route::post('transaction/tolak', [TransactionController::class, 'tolak'])->name('transaction.tolak')->middleware('auth');
Route::post('transaction/kembalikan', [TransactionController::class, 'kembalikan'])->name('transaction.kembalikan')->middleware('auth');
Route::resource('pengajuan', PengajuanController::class)->except(['show'])->middleware('auth');
Route::resource('product-category', ProductCategoryController::class)->middleware('auth');
Route::resource('laporan-absensi', LaporanAbsenController::class)->except([
    'create', 'store', 'update', 'destroy', 'show'
])->middleware('auth');
Route::post('product/show', [ProductController::class, 'show'])->name('product.show')->middleware('auth');
Route::post('transaction/show', [TransactionController::class, 'show'])->name('transaction.show')->middleware('auth');
Route::post('laporan-absensi/show', [LaporanAbsenController::class, 'show'])->name('laporan-absensi.show')->middleware('auth');
Route::resource('laporan-penggajian', LaporanPenggajianController::class)->except([
    'create', 'store', 'update', 'destroy'
])->middleware('auth');

Route::get('laporan-absensi/cetak', [LaporanAbsenController::class, 'cetak'])->name('laporan-absensi.cetak-pdf')->middleware('auth');
Route::get('laporan-absensi/print-excel', [LaporanAbsenController::class, 'printExcel'])->name('laporan-absensi.cetak-excel')->middleware('auth');
Route::get('laporan-penggajian/{id}/cetak', [LaporanPenggajianController::class, 'cetak'])->middleware('auth');
Route::get('absensi', [AbsenController::class, 'index'])->middleware('auth');
Route::post('absensi', [AbsenController::class, 'store'])->middleware('auth');
Route::get('absensi/absen', [AbsenController::class, 'tambah'])->middleware('auth');
Route::get('absensi/{tgl_absen}/edit', [AbsenController::class, 'edit'])->middleware('auth');
Route::post('absensi/{tgl_absen}/edit', [AbsenController::class, 'update'])->middleware('auth');
Route::delete('absensi/{id}', [AbsenController::class, 'delete'])->middleware('auth');

Route::get('device', [DeviceController::class, 'index'])->middleware('auth');
