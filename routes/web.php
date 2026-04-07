<?php

use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

Route::name('item.')->middleware('profile.complete')->group(function () {
    Route::get('/', [ItemController::class, 'index'])->name('index');
});

Route::get('mypage/profile', function () {
    return view('profile.edit');
})->name('profile.edit')->middleware(['auth', 'verified']);
