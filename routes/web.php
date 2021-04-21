<?php

use Illuminate\Support\Facades\Route;
use LaravelAdmin\Http\Controllers\AdminController;
use LaravelAdmin\Http\Controllers\ResourceIndexController;
use LaravelAdmin\Http\Controllers\ResourceShowController;
use LaravelAdmin\Http\Controllers\ResourceFormController;

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
Route::name('laravel-admin::')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'home'])->name('home');
    Route::get('/resources/{resource}', [ResourceIndexController::class, 'index'])->name('resources.list');
    Route::get('/resources/{resource}/{id}', [ResourceShowController::class, 'show'])->name('resources.show');
    Route::get('/resources/{resource}/{id}/edit', [ResourceFormController::class, 'edit'])->name('resources.edit');
    Route::post('/resources/{resource}/{id}/edit', [ResourceFormController::class, 'update'])->name('resources.update');
});
