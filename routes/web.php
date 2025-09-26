<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TranslatorController;

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

Route::get('/', [TranslatorController::class, 'index'])->name('translator.index');
Route::post('/translate', [TranslatorController::class, 'translate'])->name('translator.translate');
Route::get('/history', [TranslatorController::class, 'history'])->name('translator.history');
