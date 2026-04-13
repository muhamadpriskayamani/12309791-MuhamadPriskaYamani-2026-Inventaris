<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LendingController;
// use App\Http\Controllers\Operator\LendingController;


Route::get('/', function () {
    return view('landing_page');
})->name('landing_page');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('users/edit', [UserController::class, 'editSelf'])->name('users.edit.self');
    Route::put('users', [UserController::class, 'updateSelf'])->name('users.update.self');

    Route::middleware('role:admin')->group(function () {
        Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])
            ->name('users.reset-password');
        Route::resource('users', UserController::class);
        Route::get('users-export', [UserController::class, 'export'])->name('users.export');
        Route::resource('categories', CategoryController::class);
        Route::get('categories-export', [CategoryController::class, 'export'])->name('categories.export');

        Route::get('/items-export', [ItemController::class, 'export'])->name('items.export');
        Route::resource('items', ItemController::class)->except(['index']);
    });

    Route::get('items', [ItemController::class, 'index'])->name('items.index');
    Route::get('lendings', [LendingController::class, 'index'])->name('lendings.index');
    Route::get('lendings-export', [LendingController::class, 'export'])->name('lendings.export');

    Route::middleware('role:staff')->group(function () {

        Route::resource('lendings', LendingController::class)->except(['index']);

        Route::post(
            '/lendings/{lending}/returned',
            [LendingController::class, 'returned']
        )->name('lendings.returned');
        // Route::get('/lendings/{id}', [LendingController::class, 'show'])->name('lendings.show');
        Route::post('/lending-items/{id}/return', [LendingController::class, 'returnItem'])
            ->name('lending-items.return');
    });
});
