<?php

use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

Route::name('items.')->middleware('profile.complete')->group(function () {
    Route::get('/', [ItemController::class, 'index'])->name('index');
});

Route::get('mypage/profile', function () {
    return view('profiles.edit');
})->name('profiles.edit')->middleware(['auth', 'verified']);
