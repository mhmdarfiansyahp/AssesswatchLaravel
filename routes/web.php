<?php

use App\Http\Controllers\Dashboard1Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\detailsertiController;
use App\Http\Controllers\detailsertifikasiController;
use App\Http\Controllers\ForgetController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\people;
use App\Http\Controllers\peopleController;
use App\Http\Controllers\prodiController;
use App\Http\Controllers\sertifikasiController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\skemaController;
use App\Models\Skema;
use Illuminate\Contracts\Session\Session;
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

Route::get('/', [Dashboard1Controller::class, 'index'])->name('dashboard1.index');
// Route::get('dashboard1/detaildata/{year}',[Dashboard1Controller::class,'detaildata'])->name('dashboard1.detaildata');
Route::get('dashboard1/detaildata/{year}',[Dashboard1Controller::class,'detaildata'])->name('dashboard1.detaildata');
Route::get('dashboard1/alldata',[Dashboard1Controller::class,'alldata'])->name('dashboard1.alldata');

Route::get('login',[SessionController::class,'index'])->name('login.index');
Route::post('login/action',[SessionController::class,'login'])->name('login.action');
Route::get('logout',[SessionController::class,'logout'])->name('login.logout');

Route::get('forget',[ForgetController::class,'index'])->name('forget.index');
Route::post('forget/reset-password', [ForgetController::class, 'resetPassword'])->name('reset.password');


Route::middleware(['auth.pengguna'])->group(function () {
    // Routes yang perlu dilindungi
    Route::get('Dashboard', [DashboardController::class,'index'])->name('Dashboard.index');    
});


//Routes login
    //Filter data
    Route::get('Dashboard/detaildata/{year}',[DashboardController::class,'detaildata'])->name('Dashboard.detaildata');
    Route::get('Dashboard/alldata',[DashboardController::class,'alldata'])->name('Dashboard.alldata');
    Route::get('Dashboard/sertifilter/{serti}',[DashboardController::class,'sertifilter'])->name('Dashboard.sertifilter');
    Route::get('Dashboard/pilihSerti/{id_prodi}/{years}',[DashboardController::class,'pilihSerti'])->name('Dashboard.pilihSerti');
    Route::get('Dashboard/sertifikasi/{id_sertifikasi}',[DashboardController::class,'sertifikasi'])->name('Dashboard.sertifikasi');
    Route::get('Dashboard/prodibytahun/{prodi}/{tahun}',[DashboardController::class,'prodibytahun'])->name('Dashboard.prodibytahun');

    Route::middleware(['auth.pengguna'])->group(function () {

        Route::get('prodi',[prodiController::class,'index'])->name('prodi.index');
        Route::get('prodi/create',[prodiController::class,'create'])->name('prodi.create');
        Route::post('prodi/store',[prodiController::class,'store'])->name('prodi.store');
        Route::get('prodi/edit/{id}',[prodiController::class,'edit'])->name('prodi.edit');
        Route::put('prodi/update/{id}',[prodiController::class,'update'])->name('prodi.update');
        Route::delete('prodi/delete/{id}',[prodiController::class,'destroy'])->name('prodi.destroy');

    });

    Route::middleware(['auth.pengguna'])->group(function () {

        Route::get('sertifikasi',[sertifikasiController::class,'index'])->name('sertifikasi.index');
        Route::get('sertifikasi/create',[sertifikasiController::class,'create'])->name('sertifikasi.create');
        Route::post('sertifikasi/store',[sertifikasiController::class,'store'])->name('sertifikasi.store');
        Route::get('sertifikasi/edit/{id}',[sertifikasiController::class,'edit'])->name('sertifikasi.edit');
        Route::put('sertifikasi/update/{id}',[sertifikasiController::class,'update'])->name('sertifikasi.update');
        Route::delete('sertifikasi/delete/{id}',[sertifikasiController::class,'destroy'])->name('sertifikasi.destroy');
        Route::get('sertifikasi/detaildata/{year}',[sertifikasiController::class,'detaildata'])->name('sertifikasi.detaildata');

    });
// Route::get('sertifikasi/download/{id}', [sertifikasiController::class,'download'])->name('sertifikasi.download');
Route::get('sertifikasi/showPdf/{id}', [sertifikasiController::class,'showPdf'])->name('sertifikasi.showPdf');

// Route::get('Dashboard/export/excel',[peopleController::class,'export_exel']);
Route::middleware(['auth.pengguna'])->group(function () {

    Route::get('pengguna',[PenggunaController::class,'index'])->name('pengguna.index');
    Route::get('pengguna/create',[PenggunaController::class,'create'])->name('pengguna.create');
    Route::post('pengguna',[PenggunaController::class,'store'])->name('pengguna.store');
    Route::get('pengguna/{id}/edit',[PenggunaController::class,'edit'])->name('pengguna.edit');
    Route::put('pengguna/{id}',[PenggunaController::class,'update'])->name('pengguna.update');
    Route::delete('pengguna/delete/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');

});
