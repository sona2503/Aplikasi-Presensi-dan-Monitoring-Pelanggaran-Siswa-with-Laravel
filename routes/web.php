<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;  
use App\Http\Controllers\GuruController;
use App\Http\Controllers\OrtuController;
use App\Http\Controllers\CetakController;


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

Route::get('/', function () {
    return view('user/login');
});


//login, tambah user, ganti password dan logout
Route::post('register-action', [UserController::class, 'register_action'])->middleware('check.auth')->name('register.action');
Route::get('login', [UserController::class, 'login'])->middleware('check.auth')->name('login');
Route::post('login', [UserController::class, 'login_action'])->name('login.action');
Route::get('password', [UserController::class, 'password'])->middleware('check.auth')->name('password');
Route::post('password', [UserController::class, 'password_action'])->name('password.action');
Route::get('logout', [UserController::class, 'logout'])->name('logout');


//route untuk admin
Route::middleware(['check.auth'])->group(function () {
    Route::get('/data-admin', [AdminController::class, 'TampilanAwal'])->name('TampilanAwal');
    Route::get('/pilih-kelas-absensi-admin', [AdminController::class, 'PilihKelasAbsensiAdm'])->name('PilihKelasAbsensiAdm');
    Route::get('/lihat-absen-admin/{id}', [AdminController::class, 'LihatAbsenAdm'])->name('LihatAbsenAdm');
    Route::get('/tampil-pelanggaran-admin', [AdminController::class, 'TampilPelanggaranAdm'])->name('TampilPelanggaranAdm');
    Route::get('/tampil-kelas', [AdminController::class, 'TampilKelasAdm'])->name('TampilKelasAdm');
    Route::get('/tambah-kelas', [AdminController::class, 'TambahKelasAdm'])->name('TambahKelasAdm');
    Route::post('/tambah-kelas', [AdminController::class, 'TambahKelasAction'])->name('TambahKelasAction');
    Route::get('/hapus-kelas/{id_kelas}', [AdminController::class, 'HapusKelas'])->name('HapusKelas');
    Route::get('/edit-kelas/{id_kelas}', [AdminController::class, 'EditKelas'])->name('EditKelas');
    Route::put('/update-kelas', [AdminController::class, 'UpdateKelasAction'])->name('UpdateKelasAction');
    Route::get('/tambah-periode', [AdminController::class, 'TambahPeriodeAdm'])->name('TambahPeriodeAdm');
    Route::post('/tambah-periode', [AdminController::class, 'TambahPeriodeAction'])->name('TambahPeriodeAction');
    Route::get('/tampil-guru', [AdminController::class, 'TampilGuruAdm'])->name('TampilGuruAdm');
    Route::get('/tambah-guru', [AdminController::class, 'TambahGuruAdm'])->name('TambahGuruAdm');
    Route::post('/tambah-guru', [AdminController::class, 'TambahGuruAction'])->name('TambahGuruAction');
    Route::get('/hapus-guru/{nip}', [AdminController::class, 'HapusGuru'])->name('HapusGuru');
    Route::get('/edit-guru/{nip}', [AdminController::class, 'EditGuru'])->name('EditGuru');
    Route::put('/update-guru', [AdminController::class, 'UpdateGuruAction'])->name('UpdateGuruAction');
    Route::get('/tampil-user', [AdminController::class, 'TampilUserAdm'])->name('TampilUserAdm');
    Route::get('/tambah-user', [AdminController::class, 'TambahUserAdm'])->name('TambahUserAdm');
    Route::get('/hapus-user/{id}', [AdminController::class, 'HapusUser'])->name('HapusUser');
    Route::get('/diagram-analisa', [AdminController::class, 'Analisa'])->name('Analisa');
});



//route untuk guru
Route::middleware(['check.auth'])->group(function () {
    Route::get('/data-guru', [GuruController::class, 'TampilanAwalGuru'])->name('TampilanAwalGuru');
    Route::get('/pilih-kelas-tambah-siswa', [GuruController::class, 'PilihKelas'])->name('PilihKelas');
    Route::get('/tampil-siswa/{id}', [GuruController::class, 'TampilSiswa'])->name('TampilSiswa');
    Route::get('/tambah-siswa/{id}', [GuruController::class, 'TambahSiswa'])->name('TambahSiswa');
    Route::post('/tambah-siswa', [GuruController::class, 'TambahSiswaAction'])->name('TambahSiswaAction');
    Route::get('/hapus-siswa/{id}/{nisn}', [GuruController::class, 'HapusSiswa'])->name('HapusSiswa');
    Route::put('/update-siswa', [GuruController::class, 'UpdateSiswaAction'])->name('UpdateSiswaAction');
    Route::get('/edit-siswa/{nisn}', [GuruController::class, 'EditSiswa'])->name('EditSiswa');
    //tidak dipakai revisi Route::get('/pilih-kelas-absensi', [GuruController::class, 'PilihKelasAbsensi'])->name('PilihKelasAbsensi');
    Route::get('/tambah-absen', [GuruController::class, 'TambahAbsen'])->name('TambahAbsen');
    Route::post('/tambah-absen', [GuruController::class, 'TambahAbsenAction'])->name('TambahAbsenAction');
    Route::get('/pilih-cetak', [GuruController::class, 'PilihCetak'])->name('PilihCetak');
    Route::get('/seleksi-cetak/{nisn}', [GuruController::class, 'SeleksiCetak'])->name('SeleksiCetak');
    Route::get('/lihat-absen', [GuruController::class, 'LihatAbsen'])->name('LihatAbsen');
    Route::get('/edit-presensi/{tanggal}/{kelas_id}', [GuruController::class, 'EditPresensi'])->name('EditPresensi');
    Route::put('/update-presensi', [GuruController::class, 'UpdatePresensiAction'])->name('UpdatePresensiAction');
    //tidak di pakai revisi Route::get('/pilih-kelas-pelanggaran', [GuruController::class, 'PilihKelasPelanggaran'])->name('PilihKelasPelanggaran');
    Route::get('/tampil-siswa-pelanggaran', [GuruController::class, 'TampilSiswaPelanggaran'])->name('TampilSiswaPelanggaran');
    Route::get('/lihat-pelanggaran-siswa/{nisn}', [GuruController::class, 'LihatPelanggaran'])->name('LihatPelanggaran');
    Route::get('/lihat-pelanggaran-detail-siswa/{id}', [GuruController::class, 'LihatDetailPelanggaran'])->name('LihatDetailPelanggaran');
    Route::get('/tambah-pelanggaran/{nisn}', [GuruController::class, 'TambahPelanggaran'])->name('TambahPelanggaran');
    Route::post('/tambah-pelanggaran', [GuruController::class, 'TambahPelanggaranAction'])->name('TambahPelanggaranAction');
    Route::get('/hapus-pelanggaran/{id}/{nisn}', [GuruController::class, 'HapusPelanggaran'])->name('HapusPelanggaran');
    Route::get('/edit-pelanggaran/{nisn}/{id}', [GuruController::class, 'EditPelanggaran'])->name('EditPelanggaran');
    Route::put('/update-pelanggaran', [GuruController::class, 'UpdatePelanggaranAction'])->name('UpdatePelanggaranAction');
    //cetak laporan 
    Route::get('/cetak-pelanggaran/{nisn}', [CetakController::class, 'CetakPelanggaran'])->name('CetakPelanggaran');
    Route::get('/cetak-prensensi/{nisn}', [CetakController::class, 'CetakPresensi'])->name('CetakPresensi');
    Route::get('/cetak-pelanggaran-ortu', [CetakController::class, 'CetakPelanggaranOrtu'])->name('CetakPelanggaranOrtu');
    Route::get('/cetak-presensi-ortu', [CetakController::class, 'CetakPresensiOrtu'])->name('CetakPresensiOrtu'); 
});


//route untuk ortu
Route::middleware(['check.auth'])->group(function () {
    Route::get('/data-ortu', [OrtuController::class, 'TampilanAwalOrtu'])->name('TampilanAwalOrtu');
    Route::get('/lihat-absen-ortu', [OrtuController::class, 'LihatAbsenOrtu'])->name('LihatAbsenOrtu');
    Route::get('/lihat-pelanggaran-ortu', [OrtuController::class, 'LihatPelanggaranOrtu'])->name('LihatPelanggaranOrtu');
});
