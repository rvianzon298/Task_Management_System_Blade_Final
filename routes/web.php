<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskCopyController;

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
    return view('welcome');
});

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::get('/tasks/{task}', [TaskController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
Route::post('/tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');
Route::get('/taskshow', [TaskController::class, 'showCompleted'])->name('taskshow');
Route::get('/about', [UserController::class, 'about'])->name('about');

Route::get('/taskscopy', [TaskCopyController::class, 'index'])->name('user/taskscopy/index');
Route::get('/taskscopy/create', [TaskCopyController::class, 'create'])->name('taskscopy.create');
Route::post('/taskscopy', [TaskCopyController::class, 'store'])->name('taskscopy.store');
Route::get('/taskscopy/{task}', [TaskCopyController::class, 'edit'])->name('taskscopy.edit');
Route::put('/taskscopy/{task}', [TaskCopyController::class, 'update'])->name('taskscopy.update');
Route::delete('/taskscopy/{task}', [TaskCopyController::class, 'destroy'])->name('taskscopy.destroy');
Route::post('/taskscopy/{task}/complete', [TaskCopyController::class, 'complete'])->name('taskscopy.complete');

// User Routes
Route::middleware(['auth', 'user-access:user'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/taskcopyshow', [TaskCopyController::class, 'showCompletedCopy'])->name('taskcopyshow');
});

// Admin Routes
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin/home');
    Route::get('/admin/profile', [AdminController::class, 'profilepage'])->name('admin/profile');
    Route::get('/tasks/search', [TaskController::class, 'search'])->name('admin/tasks/search');
    Route::get('/tasks', [TaskController::class, 'index'])->name('admin/tasks/index');
});

// Authentication Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');
    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});
