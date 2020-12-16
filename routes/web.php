<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\VideoRoomsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessagesController;

// use App\Http\Middleware\CustomMiddleware;
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

Route::get('clear-cache', function(){
    \Artisan::call('cache:clear');
    \Artisan::call('config:clear');
    \Artisan::call('view:clear');
    \Artisan::call('route:clear');
    \Artisan::call('storage:link');
});

Route::get('/', [VideoRoomsController::class, 'index']);
Route::middleware('auth')->group(function() {

    Route::post('status-update', [HomeController::class, 'statusUpdate']);
    Route::get('user-list', [HomeController::class, 'userList']);
    Route::post('assign-exhibitor', [HomeController::class, 'assignExhibitor']);
    Route::get('user/add-avatar', [HomeController::class, 'addAvatar']);
    Route::post('user/store-avatar', [HomeController::class, 'storeAvatar']);

    Route::get('messages', [MessagesController::class, 'index']);
    Route::get('/messages/{ids}', [MessagesController::class, 'chat'])->name('messages.chat');

    Route::middleware(['auth', 'custom'])->prefix('room')->group(function() {
        Route::get('my-room', [VideoRoomsController::class, 'myRoom']);
        Route::get('my-room/close', [VideoRoomsController::class, 'closeMyRoom']);
        Route::get('join/{roomName}', [VideoRoomsController::class, 'joinRoom']);
        Route::post('create', [VideoRoomsController::class, 'createRoom']);
    });
});
Route::get('logout', [LoginController::class, 'logout']);


Auth::routes(['verify' => true]);

Route::get('/{firstname}/{lastname}/{email}/{company}/{sector}/{messe}/', [RegisterController::class, 'insertAPI']);

Auth::routes();

Route::get('/home', function(){
    return redirect('/');
})->name('home');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
