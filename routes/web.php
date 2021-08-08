<?php

use Illuminate\Support\Facades\Route;
use LaravelTarva\Http\Controllers\PageController;
use LaravelTarva\Http\Controllers\TarvaController;
use LaravelTarva\Http\Controllers\ResourceIndexController;
use LaravelTarva\Http\Controllers\ResourceShowController;
use LaravelTarva\Http\Controllers\ResourceFormController;

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
Route::name('laravel-tarva::')->prefix('tarva')->group(function () {
    Route::get('/', [TarvaController::class, 'home'])->name('home');
    Route::get('/resources/{resource}', [ResourceIndexController::class, 'index'])->name('resources.list');
    Route::get('/resources/{resource}/{id}', [ResourceShowController::class, 'show'])->name('resources.show');
    Route::get('/resources/{resource}/{id}/edit', [ResourceFormController::class, 'edit'])->name('resources.edit');
    Route::post('/resources/{resource}/{id}/edit', [ResourceFormController::class, 'update'])->name('resources.update');

    Route::get('/pages/{page}', [PageController::class, 'show'])->name('pages.show');
});
