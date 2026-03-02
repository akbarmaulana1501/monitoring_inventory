<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\DataBarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ManajemenUserController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PimpinanController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

//admin
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/index_admin',[AdminController::class,'index'])->middleware('userAccess:admin');
Route::get('/index_petugas',[PetugasController::class,'index'])->middleware('userAccess:petugas');
Route::get('/index_pimpinan',[PimpinanController::class,'index'])->middleware('userAccess:pimpinan');

Route::get('/profil', function () {
    return view('layouts.profil');
})->middleware('auth')->name('profil');

Route::put('/update_profil/{id}', [AuthController::class, 'update_profil'])->name('update_profil');




Route::get('/data_barang',[DataBarangController::class,'index'])->middleware('userAccess:admin')->name('data_barang');
Route::get('/tambah_barang',[DataBarangController::class,'tambah_data_barang'])->middleware('userAccess:admin');
Route::get('/edit_barang/{id}', [DataBarangController::class, 'edit_data_barang'])->middleware('userAccess:admin')->name('edit_barang');
Route::post('/tambah_barang',[DataBarangController::class,'store_barang']);
Route::put('/update_barang/{id}', [DataBarangController::class, 'update_data_barang'])->name('update_barang');
Route::delete('/hapus_barang/{id}',[DataBarangController::class,'hapus_barang'])->name('hapus_barang');
Route::get('/generate-kode-barang', [DataBarangController::class, 'generateKodeBarang'])->name('generate.kode.barang');

Route::get('/stok_masuk',[BarangMasukController::class,'index'])->middleware('userAccess:admin')->name('stok_masuk');
Route::get('/tambah_barang_masuk',[BarangMasukController::class,'tambah_data_barang_masuk'])->middleware('userAccess:admin');
Route::get('/edit_barang_masuk/{id}',[BarangMasukController::class,'edit_data_barang_masuk'])->middleware('userAccess:admin')->name('edit_barang_masuk');
Route::post('/tambah_stok',[BarangMasukController::class,'store_barang_masuk']);
Route::put('/update_barang_masuk/{id}', [BarangMasukController::class, 'update_data_barang_masuk'])->name('update_barang_masuk');
Route::delete('/hapus_barang_masuk/{id}', [BarangMasukController::class, 'hapus_barang_masuk'])->name('hapus_barang_masuk');

Route::get('/stok_keluar',[BarangKeluarController::class,'index'])->middleware('userAccess:admin')->name('stok_keluar');
Route::get('/tambah_barang_keluar',[BarangKeluarController::class,'tambah_data_barang_keluar'])->middleware('userAccess:admin');
Route::get('/edit_barang_keluar/{id}',[BarangKeluarController::class,'edit_data_barang_keluar'])->middleware('userAccess:admin')->name('edit_barang_keluar');
Route::post('/tambah_barang_keluar',[BarangKeluarController::class,'store_barang_keluar']);
Route::put('/update_barang_keluar/{id}', [BarangKeluarController::class, 'update_data_barang_keluar'])->name('update_barang_keluar');
Route::delete('/hapus_barang_keluar/{id}', [BarangKeluarController::class, 'hapus_barang_keluar'])->name('hapus_barang_keluar');

// Route::get('/transaksi',[TransaksiController::class,'index'])->middleware('userAccess:admin')->name('transaksi');

Route::get('/kategori',[KategoriController::class,'index'])->middleware('userAccess:admin')->name('kategori');
Route::get('/tambah_kategori',[KategoriController::class,'tambah_kategori'])->middleware('userAccess:admin');
Route::get('/edit_kategori/{id}',[KategoriController::class,'edit_kategori'])->middleware('userAccess:admin')->name('edit_kategori');
Route::post('/tambah_kategori',[KategoriController::class,'store_kategori']);
Route::put('/update_kategori/{id}', [KategoriController::class, 'update_kategori'])->name('update_kategori');
Route::delete('/hapus_kategori/{id}', [KategoriController::class, 'hapus_kategori'])->name('hapus_kategori');

Route::get('/manajemen_pengguna',[ManajemenUserController::class,'index'])->middleware('userAccess:admin')->name('manajemen_pengguna');
Route::get('/tambah_pengguna',[ManajemenUserController::class,'tambah_data_pengguna'])->middleware('userAccess:admin');
Route::post('/tambah_pengguna',[ManajemenUserController::class,'store_user']);
Route::delete('/pengguna/{id}/nonaktifkan', [ManajemenUserController::class, 'nonaktifkan'])->name('nonaktifkan_pengguna');
Route::patch('/pengguna/{id}/aktifkan', [ManajemenUserController::class, 'aktifkan'])->name('aktifkan_pengguna');

Route::get('/laporan',[LaporanController::class,'index'])->middleware('userAccess:admin')->name('laporan');
// Route::post('/laporan/filter', [LaporanController::class, 'filter'])->name('laporan.filter');
Route::post('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');



//petugas
Route::get('/data_barang_petugas',[PetugasController::class,'tampil_data_barang'])->middleware('userAccess:petugas');


Route::get('/stok_masuk_petugas',[PetugasController::class,'tampil_data_barang_masuk'])->middleware('userAccess:petugas')->name('stok_masuk_petugas');
Route::get('/tambah_stok_masuk_petugas',[PetugasController::class,'tambah_data_barang_masuk'])->middleware('userAccess:petugas')->name('tambah_stok_masuk_petugas');
Route::get('/edit_stok_masuk_petugas/{id}',[PetugasController::class,'edit_data_barang_masuk'])->middleware('userAccess:petugas')->name('edit_stok_masuk_petugas');
Route::post('/tambah_stok_petugas',[PetugasController::class,'store_barang_masuk_petugas'])->middleware('userAccess:petugas')->name('tambah_stok_petugas');
Route::put('/update_barang_masuk_petugas/{id}',[PetugasController::class,'update_barang_masuk_petugas'])->middleware('userAccess:petugas')->name('update_barang_masuk_petugas');
Route::delete('/hapus_stok_petugas/{id}',[PetugasController::class,'hapus_barang_masuk_petugas'])->middleware('userAccess:petugas')->name('hapus_stok_petugas');


Route::get('/stok_keluar_petugas',[PetugasController::class,'tampil_data_barang_keluar'])->middleware('userAccess:petugas')->name('stok_keluar_petugas');
Route::get('/tambah_stok_keluar_petugas',[PetugasController::class,'tambah_data_barang_keluar'])->middleware('userAccess:petugas')->name('tambah_stok_keluar_petugas');
Route::get('/edit_stok_keluar_petugas/{id}',[PetugasController::class,'edit_data_barang_keluar'])->middleware('userAccess:petugas')->name('edit_stok_keluar_petugas');
Route::post('/tambah_barang_keluar_petugas',[PetugasController::class,'store_barang_keluar_petugas'])->middleware('userAccess:petugas')->name('tambah_barang_keluar_petugas');
Route::put('/update_barang_keluar_petugas/{id}',[PetugasController::class,'update_barang_keluar_petugas'])->middleware('userAccess:petugas')->name('update_barang_keluar_petugas');
Route::delete('/hapus_barang_keluar_petugas/{id}',[PetugasController::class,'hapus_barang_keluar_petugas'])->middleware('userAccess:petugas')->name('hapus_barang_keluar_petugas');



//pimpinan
Route::get('/data_barang_pimpinan',[PimpinanController::class,'tampil_data_barang_pimpinan'])->middleware('userAccess:pimpinan')->name('data_barang_pimpinan');

Route::get('/laporan_pimpinan',[PimpinanController::class,'tampil_laporan'])->middleware('userAccess:pimpinan')->name('laporan_pimpinan');

Route::get('/stok_masuk_pimpinan',[PimpinanController::class,'tampil_data_barang_masuk_pimpinan'])->middleware('userAccess:pimpinan');
// Route::get('/barangkeluar', [PimpinanController::class, 'tampil_data_barang_keluar_pimpinan'])->middleware('userAccess:pimpinan')->name('barangkeluar.index');
Route::get('/stok_keluar_pimpinan',[PimpinanController::class,'tampil_data_barang_keluar_pimpinan'])->middleware('userAccess:pimpinan');
// Route::get('/barangMasuk', [PimpinanController::class, 'tampil_data_barang_keluar_pimpinan'])->middleware('userAccess:pimpinan')->name('barangkeluar.index');











