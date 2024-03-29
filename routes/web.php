<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'loginProcess'])->name('login.process');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:Admin|Dosen|Mahasiswa'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('users', [UserController::class, 'index'])->name('users');
    Route::get('users/serverside', [UserController::class, 'serverside'])->name('users.serverside');
    Route::get('users/new', [UserController::class, 'new'])->name('users.new');
    Route::post('users/new', [UserController::class, 'create'])->name('users.create');
    Route::get('users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('users/edit/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/delete', [UserController::class, 'delete'])->name('users.delete');
    Route::get('users/import', [UserController::class, 'import'])->name('users.import');
    Route::post('users/import', [UserController::class, 'importProcess'])->name('users.import.process');

    Route::get('role', [RoleController::class, 'index'])->name('role');
    Route::get('role/new', [RoleController::class, 'new'])->name('role.new');
    Route::post('role/new', [RoleController::class, 'create'])->name('role.create');
    Route::get('role/edit/{id}', [RoleController::class, 'edit'])->name('role.edit');
    Route::post('role/edit/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('role/delete', [RoleController::class, 'delete'])->name('role.delete');
    Route::get('role/permission/{id}', [RoleController::class, 'permission'])->name('role.permission');
    Route::post('role/permission/{id}', [RoleController::class, 'givePermission'])->name('role.permission.give');

    Route::get('permission', [PermissionController::class, 'index'])->name('permission');
    Route::get('permission/new', [PermissionController::class, 'new'])->name('permission.new');
    Route::post('permission/new', [PermissionController::class, 'create'])->name('permission.create');
    Route::get('permission/edit/{id}', [PermissionController::class, 'edit'])->name('permission.edit');
    Route::post('permission/edit/{id}', [PermissionController::class, 'update'])->name('permission.update');
    Route::delete('permission/delete', [PermissionController::class, 'delete'])->name('permission.delete');
});
