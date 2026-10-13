<?php

use App\Http\Controllers\DiscoverController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DiscoverController::class, 'home'])->name('home');
Route::get('/search', [DiscoverController::class, 'search'])->name('search');
Route::get('/blog', [DiscoverController::class, 'journal'])->name('journal');
Route::get('/{page}', [DiscoverController::class, 'information'])
    ->where('page', 'about|contact|disclosure|privacy|terms')->name('information');
Route::get('/blog/{article}', [DiscoverController::class, 'article'])
    ->where('article', 'sample-[a-z0-9-]+')
    ->name('article');
Route::get('/{category}/{location}/{experience}', [DiscoverController::class, 'detail'])
    ->where('category', 'activities|holidays|visas|cruises|yachts|events')
    ->where(['location' => '[a-z0-9-]+', 'experience' => 'sample-[a-z0-9-]+'])
    ->name('experience.detail');
Route::get('/{category}', [DiscoverController::class, 'category'])
    ->where('category', 'activities|holidays|visas|cruises|yachts|events')
    ->name('category');
