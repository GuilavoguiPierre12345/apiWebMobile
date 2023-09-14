<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// les routes pour l'acces a l'application avec authorization
Route::controller(AuthController::class)
        ->middleware('api')
        ->group(function () {
    Route::post('/login', 'login')->name('user.login');
    Route::post('/logout', 'logout')->name('user.logout');
    Route::post('/refresh', 'refresh')->name('user.refresh');
    Route::post('/connectedUser', 'connectedUser')->name('user.connected');
});

// les routes pour la gestion des utilisateurs
Route::prefix('/user')
        ->controller(UserController::class)
        // ->middleware('api')
        ->group(function(){
    Route::get('/listUser','index')->name('user.list');
    Route::get('/createUser','create')->name('user.create');
    Route::post('/storeUser','store')->name('user.store');
    Route::get('/editUser{id}','edit')->name('user.edit');
    Route::put('/updateUser{id}','update')->name('user.update');
    Route::delete('/deleteUser{id}','destroy')->name('user.delete');
});