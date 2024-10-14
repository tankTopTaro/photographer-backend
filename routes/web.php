<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\CaptureController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/create', [AlbumController::class, 'create'])->name('create');

Route::post('/create-captures', [CaptureController::class, 'create'])->name('create-captures');

Route::post('/album-status', [AlbumController::class, 'update'])->name('album-status');

Route::get('/photographer/album/{albumId}/user/{userId}/{token}', [AlbumController::class, 'show'])->name('album');

Route::post('/invite-user', [AlbumController::class, 'inviteUser'])->name('invite-user');
