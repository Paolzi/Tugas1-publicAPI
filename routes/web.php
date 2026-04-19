<?php

use Illuminate\Support\Facades\Route;
// Pastikan baris ini ada agar Laravel tahu di mana mencari WeatherController
use App\Http\Controllers\WeatherController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini adalah tempat kamu mendaftarkan rute untuk aplikasi kamu.
|
*/

// Halaman utama sekarang akan menampilkan form cek cuaca
Route::get('/', [WeatherController::class, 'index']);

// Rute untuk memproses input kota saat tombol "Cek" diklik
Route::post('/check', [WeatherController::class, 'check']);
