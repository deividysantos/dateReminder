<?php

use App\Http\Controllers\Reminder\CreateReminderController;
use App\Http\Controllers\Reminder\DeleteReminderController;
use App\Http\Controllers\User\RegisterUserController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/users/register', RegisterUserController::class)
    ->name('registerUser');

Route::post('/auth/login', [AuthController::class, 'login'])
    ->name('login');

Route::middleware('auth:sanctum')->group(function (){

    Route::post('/auth/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::post('/reminders', CreateReminderController::class)
        ->name('createReminder');

    Route::delete('/reminders/{reminder}', DeleteReminderController::class)
        ->name('deleteReminder');

});

