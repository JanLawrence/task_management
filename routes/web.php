<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubTaskController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard/trashed-tasks', [DashboardController::class, 'trashTask'])->middleware(['auth', 'verified'])->name('dashboard.trashed-tasks');
Route::post('/recover-task/{task}', [DashboardController::class, 'recoverTask'])->middleware(['auth', 'verified'])->name('recover-task');
Route::post('/delete-task/all', [DashboardController::class, 'deleteTrashTaskAll'])->middleware(['auth', 'verified'])->name('delete-task.all');
Route::post('/delete-task/{task}', [DashboardController::class, 'deleteTrashTask'])->middleware(['auth', 'verified'])->name('delete-task');

Route::resource('tasks', TaskController::class)->middleware(['auth', 'verified']);
Route::resource('sub-tasks', SubTaskController::class, ['except' => ['create', 'store']])->middleware(['auth', 'verified']);
Route::get('/sub-tasks/{task}/create', [SubTaskController::class, 'create'])->middleware(['auth', 'verified'])->name('sub-tasks.create');
Route::post('/sub-tasks/{task}/store', [SubTaskController::class, 'store'])->middleware(['auth', 'verified'])->name('sub-tasks.store');
Route::post('/change-status/{type}/{id}/{status}', [DashboardController::class, 'changeStatus'])->middleware(['auth', 'verified'])->name('change-status');

Route::resource('users', UserController::class)->middleware(['auth', 'verified', 'admin']);

Route::get('/profile/{user}', [DashboardController::class, 'profile'])->middleware(['auth', 'verified'])->name('profile');
Route::post('/profile/update/{user}', [DashboardController::class, 'profileUpdate'])->middleware(['auth', 'verified'])->name('profile.update');
Route::get('/change-password/{user}', [DashboardController::class, 'changePassword'])->middleware(['auth', 'verified'])->name('change-password');
Route::post('/change-password/{user}', [DashboardController::class, 'changePasswordUpdate'])->middleware(['auth', 'verified'])->name('change-password.update');


require __DIR__.'/auth.php';
