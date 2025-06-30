<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\WhatsappController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/webhook/', [WhatsappController::class, 'getToken']);
Route::post('/webhook/', [WhatsappController::class, 'getMessage']);

Route::get('cs/login', [AuthController::class, 'index'])->name('cs.login');
Route::post('cs/login', [AuthController::class, 'login'])->name('cs.login.post');

Route::middleware('auth')->group(function () {
    Route::get('cs/dashboard', function () {
        return view('chat');
    })->name('dashboard');
});
