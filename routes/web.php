<?php

use App\Http\Controllers\BlockChainController;
use App\Http\Controllers\FinalSheetController;
use App\Models\FinalSheet;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [FinalSheetController::class,'index'])->middleware(['auth'])->name('dashboard');
Route::get('/Algorithm/Phase1', [BlockChainController::class,'index_phase1'])->middleware(['auth'])->name('phase1.index');
Route::get('/Algorithm/Phase1/store', [BlockChainController::class,'store_phase1'])->middleware(['auth'])->name('phase1.store');

require __DIR__.'/auth.php';
