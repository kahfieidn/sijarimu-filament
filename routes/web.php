<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Notifications\PermohonanCreatedWA;
use App\Http\Controllers\WhatsAppController;
use Illuminate\Support\Facades\Notification;

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
    return redirect('/app');
});

Route::get('/login', function () {
    return redirect('/app');
});

Route::get('/app/sample/generate/izin/{permohonan_id}', [App\Http\Controllers\Cetak\GenerateIzin::class, 'sample'])->name('app.cetak.izin.sample');


Route::get('/auth/redirect', [App\Http\Controllers\Auth\SocialiteController::class, 'redirect'])->name('socialite.redirect');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\SocialiteController::class, 'callback'])->name('socialite.callback');

Route::group(['middleware' => []], function () {
    Route::get('/app/generate/cetak_evidence/{permohonan_id}', [App\Http\Controllers\Cetak\GenerateEvidence::class, 'generateEvidence'])->name('app.cetak.generate-evidence');
    Route::get('/app/generate/permintaan_rekomendasi/{permohonan_id}', [App\Http\Controllers\Cetak\GeneratePermintaanRekomendasi::class, 'generatePermintaanRekomendasi'])->name('app.cetak.permintaan-rekomendasi-request');
    Route::get('/app/generate/izin/{permohonan_id}', [App\Http\Controllers\Cetak\GenerateIzin::class, 'generateIzin'])->name('app.cetak.izin.request');
});
