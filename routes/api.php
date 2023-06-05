<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BlogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Tightenco\Ziggy\Ziggy;


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


/* AUTH ROUTES */

Route::get('ziggy', fn () => response()->json(new Ziggy));

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->name('login');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

/* LOGGED USER */
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

/* BLOGS ROUTES*/
Route::group([
    'middleware' => 'auth:sanctum'
], function () {
    Route::resource('/blogs', BlogController::class)->except(['edit', 'create']);
    Route::get('/blogs/{blog}/like', [BlogController::class, 'like'])->name('blogs.like');
});
