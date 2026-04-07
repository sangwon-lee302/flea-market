<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('item.index');
})->name('item.index')->middleware('profile.complete');

Route::get('mypage/profile', function () {
    return view('profile.edit');
})->name('profile.edit')->middleware(['auth', 'verified']);
