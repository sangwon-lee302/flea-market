<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShippingAddressController;
use Illuminate\Support\Facades\Route;

Route::name('items.')->group(function () {
    Route::get('/', [ItemController::class, 'index'])->name('index');
    Route::get('item/{item}', [ItemController::class, 'show'])->name('show');
    Route::get('sell', [ItemController::class, 'create'])->middleware(['auth', 'verified', 'profile.complete'])->name('create');
    Route::post('sell', [ItemController::class, 'store'])->middleware(['auth', 'verified', 'profile.complete'])->name('store');
});

Route::middleware(['auth', 'verified', 'profile.complete'])->name('profiles.')->group(function () {
    Route::get('mypage/{profile}', [ProfileController::class, 'show'])->name('show');
    Route::get('mypage/profile/{profile}', [ProfileController::class, 'edit'])->withoutMiddleware(['profile.complete'])->name('edit');
    Route::patch('mypage/{profile}', [ProfileController::class, 'update'])->withoutMiddleware(['profile.complete'])->name('update');
});

Route::middleware(['auth'])->name('likes.')->group(function () {
    Route::post('likes/{item}/toggle', [LikeController::class, 'toggle'])->name('toggle');
});

Route::middleware(['auth', 'verified', 'profile.complete'])->name('orders.')->group(function () {
    Route::get('purchase/{item}', [OrderController::class, 'create'])->name('create');
    Route::post('purchase/{item}', [OrderController::class, 'checkout'])->name('checkout');
    Route::get('purchase/{item}/success', [OrderController::class, 'success'])->name('success');
});

Route::middleware(['auth', 'verified', 'profile.complete'])->name('comments.')->group(function () {
    Route::post('comments/{item}/store', [CommentController::class, 'store'])->name('store');
});

Route::middleware(['auth', 'verified', 'profile.complete'])->name('shipping_addresses.')->group(function () {
    Route::post('purchase/address/{item}', [ShippingAddressController::class, 'editSession'])->name('edit');
    Route::post('purchase/address/{item}/update', [ShippingAddressController::class, 'updateSession'])->name('update');
});
