<?php

use App\Console\Commands\VerificaHosts;
use App\Jobs\FsockopenPorta;
use App\Models\Host;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\PingHost;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('app:verifica-hosts')->everyTenSeconds();
