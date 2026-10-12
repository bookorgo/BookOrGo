<?php

use Illuminate\Support\Facades\Route;

Route::view('/__p0/home', 'smoke.home', [
    'title' => 'Dubai travel discovery preview | BookOrGo',
    'description' => 'Protected sample homepage for server-rendering and metadata verification.',
    'canonical' => '/__p0/home',
])->name('p0.home');

Route::view('/__p0/activities/dubai/sample', 'smoke.detail', [
    'title' => 'Sample Dubai activity detail | BookOrGo',
    'description' => 'Protected sample detail page with no live offer, price or availability.',
    'canonical' => '/__p0/activities/dubai/sample',
])->name('p0.detail');

Route::view('/__p0/blog/dubai/sample-guide', 'smoke.article', [
    'title' => 'Sample Dubai planning guide | BookOrGo',
    'description' => 'Protected sample article for Blade SSR and SEO markup verification.',
    'canonical' => '/__p0/blog/dubai/sample-guide',
])->name('p0.article');
