<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PlayerController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [TeamController::class, 'index'])->name('teams');
Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
Route::get('/teams/{id}', [TeamController::class, 'show'])->name('teams.show');
Route::get('/teams/{id}/edit', [TeamController::class, 'edit'])->name('teams.edit');
Route::post('/teams/{id}', [TeamController::class, 'update'])->name('teams.update');
Route::delete('/teams/{id}', [TeamController::class, 'destroy'])->name('teams.destroy');
Route::post('/teams/{id}/toggle-status', [TeamController::class, 'toggleStatus'])->name('teams.toggleStatus');

Route::post('/players/store', [PlayerController::class, 'store'])->name('players.store');
Route::get('/players/{id}/edit', [PlayerController::class, 'edit'])->name('players.edit');
Route::put('/players/{id}', [PlayerController::class, 'update'])->name('players.update');
Route::delete('/players/{id}', [PlayerController::class, 'destroy'])->name('players.destroy');
Route::post('/players/{id}/toggle-status', [PlayerController::class, 'toggleStatus'])
    ->name('players.toggleStatus');

