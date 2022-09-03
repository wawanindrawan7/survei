<?php

use App\Http\Controllers\AmandemenController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HpeItemController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PelaksanaanController;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\PengambilanGelangController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PenilaianVendorController;
use App\Http\Controllers\PerencanaanController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/luf', function () {
    return view('auth.login-admin');
});

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('auth/', [App\Http\Controllers\GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/callback', [App\Http\Controllers\GoogleController::class, 'handleGoogleCallback'])->name('google.callback');


Route::get('users', [UserController::class, 'view']);
Route::post('users/create', [UserController::class, 'create']);
Route::get('users/delete', [UserController::class, 'delete']);

Route::get('provider', [ProviderController::class, 'view']);
Route::post('provider/create', [ProviderController::class, 'create']);
Route::post('provider/update', [ProviderController::class, 'update']);
Route::get('provider/delete', [ProviderController::class, 'delete']);


Route::get('tiket', [TiketController::class, 'view']);
Route::post('tiket/create', [TiketController::class, 'create']);
Route::post('tiket/update', [TiketController::class, 'update']);
Route::get('tiket/delete', [TiketController::class, 'delete']);

Route::get('pengeluaran', [PengeluaranController::class, 'view']);
Route::post('pengeluaran/create', [PengeluaranController::class, 'create']);
Route::post('pengeluaran/update', [PengeluaranController::class, 'update']);
Route::get('pengeluaran/delete', [PengeluaranController::class, 'delete']);

Route::get('customer', [CustomerController::class, 'view']);
Route::post('customer/create', [CustomerController::class, 'create']);
Route::post('customer/update', [CustomerController::class, 'update']);
Route::get('customer/delete', [CustomerController::class, 'delete']);

Route::get('order', [OrderController::class, 'view']);
Route::get('order/detail', [OrderController::class, 'detail']);
Route::get('order/tiket-export', [OrderController::class, 'tiketExport']);
Route::get('order-form', [OrderController::class, 'form']);

Route::get('pengambilan-gelang',[PengambilanGelangController::class, 'view']);
Route::get('pengambilan-gelang/submit',[PengambilanGelangController::class, 'submit']);

Route::post('tagihan/confirm', [TagihanController::class, 'confirm']);
Route::get('tagihan/validasi', [TagihanController::class, 'validasi']);
Route::get('tagihan', [TagihanController::class, 'view']);


Route::get('cart/item',[OrderController::class,'cart']);
Route::post('cart/add',[OrderController::class,'cartAdd']);
Route::get('cart/add-qty',[OrderController::class,'cartAddQty']);
Route::get('cart/min-qty',[OrderController::class,'cartMinQty']);
Route::post('cart/checkout',[OrderController::class,'checkOut']);






