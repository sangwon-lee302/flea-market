<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('profile.complete')->name('items.')->group(function () {
    Route::get('/', [ItemController::class, 'index'])->name('index');
});

Route::middleware(['auth', 'verified'])->name('profiles.')->group(function () {
    Route::get('mypage', [ProfileController::class, 'show'])->name('show');
    Route::get('mypage/profile/{profile}', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('mypage/{profile}', [ProfileController::class, 'update'])->name('update');
});
