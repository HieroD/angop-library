<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:staff')->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::resource('/admin/books', BookController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names('admin.books');
    Route::resource('/admin/members', MemberController::class)
        ->only(['index', 'store', 'update', 'destroy'])
        ->names('admin.members');
    Route::get('/admin/borrowings', [BorrowController::class, 'index'])->name('admin.borrowings.index');
    Route::patch('/admin/borrowings/{borrowing}/approve', [BorrowController::class, 'approve'])->name('admin.borrowings.approve');
    Route::patch('/admin/borrowings/{borrowing}/reject', [BorrowController::class, 'reject'])->name('admin.borrowings.reject');
});
