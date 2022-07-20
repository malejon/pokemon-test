<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\CleaningCenterController;
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
Route::get('/', [CleaningCenterController::class, 'index'])->name('main')->middleware('dirt');
Route::post('/start', [CleaningCenterController::class, 'startCleaning'])->name('start_cleaning');
Route::resource("trainers", TrainerController::class);
