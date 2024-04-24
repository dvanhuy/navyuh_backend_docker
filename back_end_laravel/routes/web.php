<?php

use App\Http\Controllers\Testing;
use Illuminate\Http\Request;
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
Route::get('/dd-variable',[Testing::class, 'ddVariable'])->name('ddvariable');
Route::get('/dd-request',[Testing::class, 'ddrequest'])->name('ddrequest');
