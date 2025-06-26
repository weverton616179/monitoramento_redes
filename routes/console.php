<?php

use App\Jobs\ForsokenPorta;
use App\Models\Historico;
use App\Models\Historicoportas;
use App\Models\Host;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\PingHost;
use App\Models\Tempo;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::call(function () {
    $tempos = Tempo::all();
    foreach ($tempos as $tempo) {
        $dataEhora = Carbon::parse($tempo->next_run_at);
        if ($dataEhora->isPast()) {
            $hosts = $tempo->hosts;
            $portas = $tempo->portas;
            $tempo->next_run_at = Carbon::now()->addMinutes(intval($tempo->tempo));
            $tempo->save();
            if ($hosts->count() > 0) {
                foreach ($hosts as $host) {PingHost::dispatch($host);}
                
            } 
            if ($portas->count() > 0) {
                foreach ($portas as $porta) {ForsokenPorta::dispatch($porta);}
            }
            if($hosts->count() <= 0 && $portas->count() <= 0) {
                $tempo->delete();
            }
            
            //else {
            //     $tempo->delete();
            // }
            
        }
    }
})->everyTenSeconds();

// Schedule::call(function () {

//     $hosts = Host::all();
//     foreach ($hosts as $host) {
//         PingHost::dispatch($host);
//     }
// })->everyTenSeconds();

