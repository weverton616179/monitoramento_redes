<?php

use App\Jobs\ForsokenPorta;
use App\Models\Historico;
use App\Models\Historicoportas;
use App\Models\Host;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\PingHost;
use App\Models\Porta;
use App\Models\Tempo;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::call(function () {

    $hosts = Host::all();
    $portas = Porta::all();
    foreach ($hosts as $host) {
        $tempo_host = $host->tempo;
        $historico_host = $host->historicos->first();       

        if ($historico_host == null) {
            PingHost::dispatch($host);
        } else {
            $now = Carbon::now();
            $data = $historico_host->created_at;
            $diff = $data->diffInMinutes($now);
            if ($diff >= $tempo_host) {
                PingHost::dispatch($host);
            }
        }

        foreach($host->portas as $porta) {

        }
    }

    foreach($portas as $porta) {
        $pivot = $porta->host->pivot->where('host_id', $host->id)->first();
        $tempo_porta = $pivot->tempo;
        $historico_porta = $porta->historicos->where('host_id', $host->id)->first();

        if ($historico_porta == null) {
            ForsokenPorta::dispatch($porta, $host);
        } else {
            $now = Carbon::now();
            $data = $historico_porta->created_at;
            $diff = $data->diffInMinutes($now);
            if ($diff >= $tempo_porta) {
                ForsokenPorta::dispatch($porta, $host);
            }
        }
    }
})->everyTenSeconds();

// Schedule::call(function () {

//     $hosts = Host::all();
//     foreach ($hosts as $host) {
//         PingHost::dispatch($host);
//     }
// })->everyTenSeconds();

