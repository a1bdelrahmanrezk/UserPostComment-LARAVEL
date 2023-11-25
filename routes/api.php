<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(PostController::class)->group(function (){
    Route::group(['prefix'=>'posts'],function(){
        Route::get('/','index')->name('users');
        Route::get('/{id}','show')->name('user.show');
        Route::post('/','store')->name('user.store');
        Route::patch('/{id}','edit')->name('user.edit');
        Route::delete('/{id}','delete')->name('user.delete');
    });
});
Route::controller(UserController::class)->group(function (){
    Route::group(['prefix'=>'users'],function(){
        Route::get('/','index')->name('users');
        Route::get('/{id}','show')->name('user.show');
        Route::post('/','store')->name('user.store');
        Route::post('/{id}','edit')->name('user.edit');
        Route::delete('/{id}','delete')->name('user.delete');
    });
});


