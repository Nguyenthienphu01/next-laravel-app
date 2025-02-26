<?php

use Illuminate\Support\Facades\Route;
use App\Http\Api\V1\Controllers\FlashcardController;
use App\Http\Api\V1\Controllers\SetController;
use App\Http\Api\V1\Controllers\System\HistoryController;

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

Route::group([
    'prefix' => 'v1',
    'namespace' => '\\App\\Http\\Api\\V1\\Controllers',
], function () {
    Route::post('/login', 'AuthController@login');

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::group(['prefix' => 'auth'], function () {
            Route::post('/logout', 'AuthController@logout');
            Route::patch('/change-password', 'AuthController@changePassword');
        });

        // Account
        Route::get('/list-account', 'AccountController@listAccount');
        Route::post('/create-account', 'AccountController@createAccount');
        Route::post('/update-account/{id}', 'AccountController@updateAccount');
        Route::delete('/delete-account/{id}', 'AccountController@deleteAccount');

        // System 
        Route::get('/history', [HistoryController::class, 'getHistory']);

        // Library

        Route::post('/flashcards', [FlashcardController::class, 'store']);
    });
});
