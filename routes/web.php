<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/products', ProductController::class);
Route::post('/insert/pos', [ProductController::class, 'insertPos'])->name('insert.pos');
Route::get('/increase/quantity/{id}', [ProductController::class, 'increaseQuantity'])->name('increase.quantity');
Route::get('/total/pos', [ProductController::class, 'getAllPos'])->name('total.pos');
Route::get('/total/quantity', [ProductController::class, 'totalQuantity'])->name('total.quantity');

