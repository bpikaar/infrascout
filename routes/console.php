<?php

use Illuminate\Support\Facades\Schedule;

//Artisan::command('inspire', function () {
//    $this->comment(Inspiring::quote());
//})->purpose('Display an inspiring quote');

// This doesn't work on shared hosting because proc_open is blocked
//Schedule::command('queue:work --stop-when-empty')
//    ->everyMinute()
//    ->withoutOverlapping();

Schedule::call(function () {
    Artisan::call('queue:work', [
        '--stop-when-empty' => true,
        '--tries' => 3,
    ]);
})->everyMinute();
