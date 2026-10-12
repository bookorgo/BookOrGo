<?php

use Illuminate\Support\Facades\Schedule;

Schedule::call(function (): void {
    $proof = [
        'task' => 'P0-L04b scheduled no-op',
        'status' => 'executed',
        'environment' => app()->environment(),
        'executed_at' => now()->utc()->toIso8601String(),
    ];

    file_put_contents(
        storage_path('framework/p0-scheduler-proof.json'),
        json_encode($proof, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES).PHP_EOL,
    );
})->name('p0-no-op')->everyMinute();
