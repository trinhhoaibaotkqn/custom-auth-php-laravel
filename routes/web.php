<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware('notloggedin')->group(function () {
    Route::get('/login', [AuthController::class, 'createLogin'])->name('login');
    Route::get('/register', [AuthController::class, 'createRegister'])->name('register');
    Route::post('/login', [AuthController::class, 'storeLogin']);
    Route::post('/register', [AuthController::class, 'storeRegister']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('loggedin');

Route::group(['prefix' => 'user', 'middleware' => ['loggedin']],function () {
    Route::get('/profile', [UserController::class, 'viewProfile'])->name('profile');
    
    Route::post('/change-name', [UserController::class, 'changeName']);
    Route::middleware('isAdmin')->group(function () {
        Route::get('/manager-user', [UserController::class, 'viewManagerUser'])->name('update');
        Route::post('/add-new-user', [UserController::class, 'addNewUser']);
        Route::patch('/update-user/{id}', [UserController::class, 'updateUser']);
        Route::patch('/update-user-account/{id}', [UserController::class, 'updateUserAccount']);
        Route::delete('/delete-user-account/{id}', [UserController::class, 'deleteUser']);
    });

    // Route::post('/add-new-user', [UserController::class, 'addNewUser']);
    //     Route::patch('/update-user/{id}', [UserController::class, 'updateUser']);
    //     Route::patch('/update-user-account/{id}', [UserController::class, 'updateUserAccount']);
    //     Route::delete('/delete-user-account/{id}', [UserController::class, 'deleteUser']);
});