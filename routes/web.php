<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/create', [HomeController::class, 'create'])->name('create');

Route::post('/create-captures', [HomeController::class, 'createCaptures'])->name('create-captures');

Route::post('/album-status', [AlbumController::class, 'update'])->name('album-status');

Route::get('/photographer/album/{albumId}/user/{userId}/{token}', [AlbumController::class, 'show'])->name('album');