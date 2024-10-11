<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/create', [HomeController::class, 'create'])->name('create');

Route::post('/create-captures', [HomeController::class, 'createCaptures'])->name('create-captures');
