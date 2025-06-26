<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Historico;
use App\Models\Historicoportas;
use Acamposm\Ping\Ping;
use Acamposm\Ping\PingCommandBuilder;

class PingHost implements ShouldQueue
{
    use Queueable;

    protected $host;

    /**
     * Create a new job instance.
     */
    public function __construct($host)
    {
        $this->host = $host;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $host = $this->host;

        if($host->monitorar){
            $ip = $host->ip;
            $host_id = $host->id;
            // $portas = $host->portas;

            $historico = new Historico();
            $historico->host_id = $host_id;

            $ping = null;
            try {
                $command = (new PingCommandBuilder($ip))->count(3)->packetSize(4)->ttl(40);
                $ping = (new Ping($command))->run();
            } catch (\Exception $e) {
                $ping = null;
            }

            

            if($ping){
                $historico->pk_loss = $ping->statistics->packet_loss;
                $historico->tr_min = $ping->rtt->min * 1000;
                $historico->tr_max = $ping->rtt->max * 1000;
                $historico->tr_med = $ping->rtt->avg * 1000;
                if($ping->statistics->packet_loss >= $host->perda_crt || ($ping->rtt->avg * 1000) >= $host->tempo_crt) {
                    $historico->status = 'PROBLEMA';
                }elseif ($ping->statistics->packet_loss >= $host->perda_wng || ($ping->rtt->avg * 1000) >= $host->tempo_wng) {
                    $historico->status = 'WARNING';
                } else {
                    $historico->status = 'ATIVO';
                }

            } else {
                $historico->status = 'PROBLEMA';
                $historico->pk_loss = 100;
                $historico->tr_min = 0;
                $historico->tr_max = 0;
                $historico->tr_med = 0;
            }

            $historico->save();

            // foreach($portas as $porta) {

            //     if($porta->ativa) {
            //         $porta_num = $porta->porta;
            //         $historico_porta = new Historicoportas();
            //         $historico_porta->porta_id = $porta->id;
            //         $historico_porta->historico_id = $historico->id;

            //         $socket = @fsockopen($ip, $porta_num, $errno, $errstr, 5);
            //         if(!$socket || $socket == null){
            //             $historico_porta->status = false;
            //         } else {
            //             $historico_porta->status = true;
            //         }
            //         $historico_porta->save();
            //     }
            // }

            info($historico);

        }
    }
}
