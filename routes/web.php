<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ReturnController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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
    Route::get('/admin/returns', [ReturnController::class, 'index'])->name('admin.returns.index');
    Route::post('/admin/returns/{borrowing}', [ReturnController::class, 'store'])->name('admin.returns.store');
    Route::patch('/admin/returns/{returnRecord}/payment', [ReturnController::class, 'updatePayment'])->name('admin.returns.payment.update');
});

Route::middleware('auth:member')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'member'])->name('member.dashboard');
});
