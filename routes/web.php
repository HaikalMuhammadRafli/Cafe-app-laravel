<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\MasakanController;
use App\Http\Controllers\KasirMejaController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\AdminPagesController;
use App\Http\Controllers\KasirPagesController;
use App\Http\Controllers\KasirPelangganController;
use App\Http\Controllers\KasirTransaksiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PagesController::class, 'homepage'])->name('home');
Route::get('/home', [HomeController::class,'index']);
Route::get('/menu', [PagesController::class, 'menu'])->name('menu');

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::post('/buat-order', [PagesController::class, 'buat_order'])->name('buat.order');
    Route::post('/tambah-masakan/{id}', [PagesController::class, 'tambah_masakan'])->name('tambah.masakan');
    Route::delete('/detailorder-delete/{id}', [PagesController::class, 'detailorder_delete'])->name('detailorder.delete');
    Route::post('/tambah-keterangan-detail/{id}', [PagesController::class, 'ket_detail'])->name('ket.detail');
    Route::post('/tambah-keterangan-order/{id}', [PagesController::class, 'ket_order'])->name('ket.order');
    Route::get('/order-detail/{id}', [PagesController::class, 'order_detail'])->name('order.detail');
    Route::get('/order-submit/{id}', [PagesController::class, 'order_submit'])->name('order.submit');
    Route::get('/filter-masakan', [PagesController::class, 'menu'])->name('menu.masakan.filter');
});

Route::group(['prefix' => 'kasir', 'middleware' => ['auth', 'role:Kasir']], function() {
    Route::get('/dashboard', [KasirPagesController::class, 'dashboard'])->name('kasir.dashboard');
    Route::get('/meja-tersedia/{id}', [KasirMejaController::class, 'meja_tersedia'])->name('kasir.meja.tersedia');
    Route::get('/meja-terpakai/{id}', [KasirMejaController::class, 'meja_terpakai'])->name('kasir.meja.terpakai');
    Route::resource('pelanggan-kasir', KasirPelangganController::class);
    Route::resource('meja-kasir', KasirMejaController::class);
    Route::resource('transaksi-kasir', KasirTransaksiController::class);
    Route::get('/transaksi-bayar/{id}', [KasirTransaksiController::class, 'transaksi_bayar'])->name('kasir.transaksi.bayar');
    Route::get('/laporan', [KasirPagesController::class, 'laporan'])->name('kasir.laporan');
    Route::get('/search-pelanggan', [KasirPelangganController::class, 'index'])->name('kasir.pelanggan.search');
    Route::get('/filter-transaksi', [KasirTransaksiController::class, 'index'])->name('kasir.transaksi.filter');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:Admin']], function() {
    Route::get('/dashboard', [AdminPagesController::class,'dashboard'])->name('admin.dashboard');
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('meja', MejaController::class);
    Route::get('/meja-tersedia/{id}', [KasirMejaController::class, 'meja_tersedia'])->name('meja.tersedia');
    Route::get('/meja-terpakai/{id}', [KasirMejaController::class, 'meja_terpakai'])->name('meja.terpakai');
    Route::resource('masakan', MasakanController::class);
    Route::resource('transaksi', TransaksiController::class);
    Route::get('/transaksi-bayar/{id}', [TransaksiController::class, 'transaksi_bayar'])->name('transaksi.bayar');
    Route::get('/laporan', [AdminPagesController::class, 'laporan'])->name('laporan');
    Route::get('/filter-masakan', [MasakanController::class, 'index'])->name('masakan.filter');
    Route::get('/filter-pelanggan', [PelangganController::class, 'index'])->name('pelanggan.filter');
    Route::get('/filter-transaksi', [TransaksiController::class, 'index'])->name('transaksi.filter');
});
