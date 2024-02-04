<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\LoginContoroller;

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
    return view('home');
});

Route::post('/login', [LoginContoroller::class, 'login'])->name('login');
Route::get('/login', [LoginContoroller::class, 'login'])->name('login');
Route::get('/register', [RegisterController::class, 'create'])->name('register.create');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/logout', [LogoutController::class, 'destroy'])->name('logout')->middleware('auth');
Route::post('/logout', [LogoutController::class, 'destroy'])->name('logout')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/chat/roomList', [RoomController::class, 'index'])->name('roomList.index');
    Route::post('/chat/roomList', [RoomController::class, 'index'])->name('roomList.index');
    Route::get('/chat/create', [RoomController::class, 'create'])->name('room.create');
    Route::post('/chat/create', [RoomController::class, 'store'])->name('room.store');
    Route::get('/chat/messageRoom/{room_id}', [MessageController::class, 'index'])->name('messageRoom.index');
    Route::post('/chat/messageRoom/{room_id}/create', [MessageController::class, 'create'])->name('messageRoom.create');
});
