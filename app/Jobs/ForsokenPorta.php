<?php

namespace App\Jobs;

use App\Models\Historicoportas;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ForsokenPorta implements ShouldQueue
{
    use Queueable;

    protected $porta;
    protected $host;

    /**
     * Create a new job instance.
     */
    public function __construct($porta, $host)
    {
        $this->porta = $porta;
        $this->host = $host;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $porta = $this->porta;
        $host = $this->host;    

        if($porta->ativa) {

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
        }
    }
}
