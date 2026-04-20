<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::name('items.')->group(function () {
    Route::get('/', [ItemController::class, 'index'])->name('index');
    Route::get('item/{item}', [ItemController::class, 'show'])->name('show');
});

// do not remove verified middleware since it is crucial to meet the specs
Route::middleware(['auth', 'verified'])->name('profiles.')->group(function () {
    Route::get('mypage/{profile}', [ProfileController::class, 'show'])->name('show');
    Route::get('mypage/profile/{profile}', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('mypage/{profile}', [ProfileController::class, 'update'])->name('update');
});

Route::middleware(['auth'])->name('likes.')->group(function () {
    Route::post('likes/{item}/toggle', [LikeController::class, 'toggle'])->name('toggle');
});

Route::middleware(['auth', 'verified'])->name('orders.')->group(function () {
    Route::get('purchase/{item}', [OrderController::class, 'create'])->name('create');
});

Route::middleware(['auth', 'verified'])->name('comments.')->group(function () {
    Route::post('comments/{item}/store', [CommentController::class, 'store'])->name('store');
});
