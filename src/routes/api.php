<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/auth', [AuthController::class, 'auth'])->name('auth');
Route::post('/registr', [AuthController::class, 'registr'])->name('registr');

Route::middleware(['role:user,admin'])
    ->prefix('users')
    ->name('users.')
    ->group(function () {
        Route::get('/', [UserController::class, 'test']);
    });

Route::middleware(['role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/applications', [AdminController::class, 'indexApplications'])->name('applications.index');
        Route::put('/applications', [AdminController::class, 'acceptApplications'])->name('applications.accept');
        Route::delete('/applications/{id}', [AdminController::class, 'deleteApplications'])->name('applications.delete');
        Route::get('/users', [AdminController::class, 'indexUsers'])->name('users.index');
        Route::delete('/users', [AdminController::class, 'destroyUsers'])->name('users.destroy');
    });

Route::middleware(['role:user'])
    ->prefix('products')
    ->name('products.')
    ->group(function () {
        // Route::get('/');
        // Route::post('/');
        // Route::get('/{id}');
    });
