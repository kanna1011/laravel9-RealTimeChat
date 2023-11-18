<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\RoomListController;

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

Route::post('/chat/roomList', [RoomListController::class, 'index'])->name('roomList.index');
// Route::get('/', [ChatController::class, 'index'])->name('chat.index');
// Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');

// Route::get('/chat/create', [ChatController::class, 'create'])->name('chat.create');
// Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');
// Route::get('/chat/{chatRoom}', [ChatController::class, 'show'])->name('chat.show');

// Route::get('/', [ChatController::class, 'index'])->name('chat.index');
// Route::get("posts", [ChatController::class, 'index'])->name('post.index');
// Route::post("posts/create", [ChatController::class, 'create'])->name('post.create');