<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

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

/*
Route::get('/', function () {
    return view('landing');
});
*/

Route::get('/', LandingController::class);

Route::get('/about', [AboutController::class, 'index']);

Route::get('/contact-us', [ContactController::class, 'index']);

Route::post('/contact-us', [ContactController::class, 'store']);
