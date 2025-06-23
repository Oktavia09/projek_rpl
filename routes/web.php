<?php

use App\Http\Controllers\Admin\AdminControllerMapel;
use App\Http\Controllers\Admin\adminControllerSiswa;
use App\Http\Controllers\Admin\adminControllerGuru;
use App\Http\Controllers\Admin\AdminJadwalMengajar;
use App\Http\Controllers\Admin\KelasSiswaController;
use App\Http\Controllers\Guru\GuruJadwalController;
use App\Http\Controllers\Guru\SiswaPrensensiController;
use App\Http\Controllers\Guru\UploadTugasController;
use App\Http\Controllers\HomeSiswaController;
use App\Http\Controllers\Siswa\PresensiSiswaController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\LoginController;

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/Register', [RegisterController::class, 'create'])->name('register.create');
Route::post('/Register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/Login', [LoginController::class, 'create'])->name('login');
Route::post('/Login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [SiswaController::class, 'logout'])->name('logout');

Route::get('/Dashboard', [DashboardController::class, 'index'])->name('dashboard.index');



Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {


    // Halaman utama / dashboard siswa
    // Route::get('/dashboard-utama', [HomeSiswaController::class, 'index'])->name('home');

    // Dashboard status & data PPDB
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('home');

    // Formulir PPDB
    Route::get('/formulir', [SiswaController::class, 'create'])->name('formulir');
    Route::post('/formulir', [SiswaController::class, 'store'])->name('store');

    // Logout siswa
    Route::post('/logout', [SiswaController::class, 'logout'])->name('logout');
    route::get('/dashboard-siswa', [SiswaController::class, 'dashboard_siswa'])->name('dashboard_siswa');

    Route::resource('presensi-siswa', PresensiSiswaController::class)->names('presensi-siswa');

});


Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    // /guru/dashboard → route name: guru.dashboard
    Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('dashboard');

    Route::resource('tugas', UploadTugasController::class)->parameters([
        'tugas' => 'tugas' // atasi singularisasi ke 'tuga'
    ]);
    Route::resource('jadwal_ajar', GuruJadwalController::class)->names('jadwal_ajar');
    Route::resource('presensi-siswa', SiswaPrensensiController::class)->names('presensi-siswa');



});


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {



    Route::get('/siswa', [AdminControllerSiswa::class, 'index'])->name('siswa.index');
    Route::put('/siswa/{siswa_id}', [AdminControllerSiswa::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{siswa_id}', [AdminControllerSiswa::class, 'destroy'])->name('siswa.destroy');
    Route::resource('/guru', AdminControllerGuru::class)->names('guru');
    Route::resource('/mapel', AdminControllerMapel::class)->names('mapel');
    Route::resource('/jadwal_mengajar', AdminJadwalMengajar::class)->names('jadwal_mengajar');
    Route::resource('/kelas-siswa', KelasSiswaController::class)->names('kelas-siswa');




});

