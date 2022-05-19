<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::prefix('recipients')->group(
    function () {
        Route::get('/', [App\Http\Controllers\RecipientsController::class, 'showAll'])->name('showAll')->middleware('superadmin');
        Route::get('/getRecipientsByUserId', [App\Http\Controllers\RecipientsController::class, 'getRecipientsByUserId'])->middleware('superadmin');
        Route::post('/addRecipient', [App\Http\Controllers\RecipientsController::class, 'addRecipient'])->middleware('superadmin');
        Route::post('/deleteRecipient/{id}', [App\Http\Controllers\RecipientsController::class, 'deleteRecipient'])->middleware('superadmin');
        Route::post('/editRecipient/{id}', [App\Http\Controllers\RecipientsController::class, 'editRecipient'])->middleware('superadmin');
        Route::get('/getCurrentUser', [App\Http\Controllers\RecipientsController::class, 'getCurrentUser']);
        Route::get('/getUsers', [App\Http\Controllers\RecipientsController::class, 'getUsers']);
        Route::post('/sendTransfer', [App\Http\Controllers\RecipientsController::class, 'sendTransfer']);
        Route::get('/getActions', [App\Http\Controllers\RecipientsController::class, 'getActions']);
    }
);

Route::prefix('transfers')->group(
    function () {
        Route::get('/', [App\Http\Controllers\TransfersController::class, 'show']);
    }
);

