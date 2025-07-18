<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
 * NOTE: URLは複数形で記述すること
 * https://qiita.com/mserizawa/items/b833e407d89abd21ee72
 */

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
