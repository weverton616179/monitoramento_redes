<?php

namespace App\Jobs;

use App\Models\Historicoportas;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ForsokenPorta implements ShouldQueue
{
    use Queueable;

    protected $porta;

    /**
     * Create a new job instance.
     */
    public function __construct($porta)
    {
        $this->porta = $porta;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $porta = $this->porta;   

        if($porta->ativa) {
            $hosts = $porta->host()->get();
            foreach($hosts as $host){
            
                $porta_num = $porta->porta;
                $historico_porta = new Historicoportas();
                $historico_porta->porta_id = $porta->id;
                $historico_porta->host_id = $host->id;

                $socket = @fsockopen($host->ip, $porta_num, $errno, $errstr, 5);
                if(!$socket || $socket == null){
                    $historico_porta->status = false;
                } else {
                    $historico_porta->status = true;
                }
                $historico_porta->save();
                //nao ta encontrando a coluna host_id
            }
        }
    }
}
