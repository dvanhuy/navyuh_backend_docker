<?php

use App\Http\Controllers\Admin\ServerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserServerController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', [AuthController::class, 'login']);
Route::get('login/google', [AuthController::class, 'redirectGoogleLogin']);
Route::get('login/google/callback', [AuthController::class, 'callbackGoogleLogin']);

Route::post('register', [AuthController::class, 'register']);
Route::get('register/verify', [AuthController::class, 'verify']);
Route::post('forgot-password', [AuthController::class, 'sendEmailResetPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);

//'middleware'=>'cors',
Route::group(['middleware'=>[IsAdmin::class],'prefix'=>'admin'], function () 
{
    Route::apiResource('categorys',CategoryController::class);
    Route::apiResource('servers',ServerController::class);
});


Route::group(['middleware'=>[IsLogin::class],'prefix'=>'servers'], function () 
{
    Route::get('', [UserServerController::class,'index']);
    Route::get('{idserver}', [UserServerController::class,'show']);
    Route::get('join/{idserver}', [UserServerController::class,'join']);
});

Route::group(['middleware'=>[IsLogin::class],'prefix'=>'messages'], function () 
{
    Route::post('', [MessageController::class,'store']);
});

