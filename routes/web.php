<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

// TODO: Implementing view

Auth::routes();

// Default route
Route::get('/home', HomeController::class.'@index')->name('home');

Route::get('/', function (){
    return redirect('/home');
});

// User route
Route::resource('user', UserController::class);
Route::get('/email/{id}', UserController::class.'@editMail')->name('mail_user');
Route::put('/email/{id}/change', UserController::class.'@updateMail')->name('mail_store');
Route::get('/username/{id}', UserController::class.'@editUsername')->name('username_user');
Route::put('/username/{id}/change', UserController::class.'@updateUsername')->name('username_store');
Route::get('/password/{id}', UserController::class.'@editPassword')->name('password_user');
Route::put('/password/{id}/change', UserController::class.'@updatePassword')->name('password_store');

// Anggota route
Route::resource('anggota', AnggotaController::class);

// Buku route
Route::resource('buku', BukuController::class);
Route::get('/format/buku', BukuController::class.'@format')->name('format_buku');
Route::post('/import/buku', BukuController::class.'@import')->name('import_buku');

// Transaksi route
Route::resource('transaksi', TransaksiController::class);

// Laporan
Route::get('/laporan/cetak', LaporanController::class.'@laporan')->name('laporan_cetak');
