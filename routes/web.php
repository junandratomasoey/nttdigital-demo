<?php

use App\Http\Controllers\DemoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DemoController::class, 'beranda'])->name('beranda');
Route::post('/kirim/{tipe}', [DemoController::class, 'kirim'])->middleware('throttle:6,1')->name('kirim');

Route::get('/{halaman}', [DemoController::class, 'halaman'])
    ->where('halaman', '(?!admin|livewire|filament|up$)[a-z\-]+')
    ->name('halaman');
Route::get('/{halaman}/{slug}', [DemoController::class, 'detail'])
    ->where(['halaman' => '[a-z\-]+', 'slug' => '[a-z0-9\-]+'])
    ->name('detail');
