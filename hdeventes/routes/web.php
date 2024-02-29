<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EventController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactController;

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



Route::get('/',  [EventController::class, 'index']);
// middleware só vai ser acessado com usúario logado;
Route::get('/events/create',  [EventController::class, 'create']);
Route::get('/events/{id}',  [EventController::class, 'show']);
Route::post('/events',  [EventController::class, 'store']);
Route::delete('/events/{id}',  [EventController::class, 'destroy']);
Route::get('/events/edit/{id}', [EventController::class, 'edit']);
Route::put('/events/update/{id}', [EventController::class, 'update']);

Route::get('/contact', [ContactController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);

Route::get('/product_testes/{id?}', function ($id = null) {
    return view('product', ['id' => $id]);
});

Route::get('/dashboard', [EventController::class, 'dashboard']);

Route::post('/events/join/{id}', [EventController::class, 'joinEvent']);
Route::delete('/events/leave/{id}', [EventController::class, 'leaveEvent']);

