<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

if ($this->app->environment('local')) {
    // 毎日telescopeの古いデバッグ情報を削除する
    Schedule::command('telescope:prune')->daily();
}
