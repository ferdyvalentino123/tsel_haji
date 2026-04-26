<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();
Schedule::call(function () {
    DB::table('role_users')
        ->where('is_setoran', 1)
        ->where('updated_at', '<=', now())
        ->update(['is_setoran' => 0]);
})->everyTwoMinutes();
