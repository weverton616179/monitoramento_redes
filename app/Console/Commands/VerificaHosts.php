<?php

namespace App\Console\Commands;

use App\Jobs\FsockopenPorta;
use App\Jobs\PingHost;
use App\Models\Host;
use Carbon\Carbon;
use Illuminate\Console\Command;

class VerificaHosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:verifica-hosts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hosts = Host::all();
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
                $pivot = $porta->pivot;
                $tempo_porta = $pivot->tempo;
                $historico_porta = $porta->historicoportas->where('host_id', $host->id)->first();
                if ($historico_porta == null) {
                    FsockopenPorta::dispatch($porta, $host);
                } else {
                    $now = Carbon::now();
                    $data = $historico_porta->created_at;
                    $diff = $data->diffInMinutes($now);
                    if ($diff >= $tempo_porta) {
                        FsockopenPorta::dispatch($porta, $host);
                    }
                }
            }
        }
    }
}
