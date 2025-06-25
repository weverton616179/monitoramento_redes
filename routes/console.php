<?php

use App\Models\Historico;
use App\Models\Historicoportas;
use App\Models\Host;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\PingHost;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {

    $hosts = Host::all();
    foreach ($hosts as $host) {
        PingHost::dispatch($host);
    }
})->everyTenSeconds();

