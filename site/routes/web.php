<?php

use App\Http\Controllers\DiscoverController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DiscoverController::class, 'home'])->name('home');
Route::get('/search', [DiscoverController::class, 'search'])->name('search');
Route::get('/blog', [DiscoverController::class, 'journal'])->name('journal');
Route::get('/{category}', [DiscoverController::class, 'category'])
    ->where('category', 'activities|holidays|visas|cruises|yachts|events')
    ->name('category');
