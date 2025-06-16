<?php

use App\Models\Historico;
use App\Models\Historicoportas;
use App\Models\Host;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {

    $hosts = Host::all();
    foreach ($hosts as $host) {
        if($host->ativa){
            $ip = $host->ip;
            $host_id = $host->id;
            $portas = $host->portas;
            

            $historico = new Historico();
            $historico->host_id = $host_id;
            $ping = shell_exec("C:\Windows\system32\ping $ip");

            if (preg_match('/Esgotado\s*o\s*tempo/', $ping, $esgotado)) {$esgotado_found = true;} else {$esgotado_found = false;}
            if (preg_match('/tente\s*novamente./', $ping, $tente)) {$tente_found = true;} else {$tente_found = false;}

            if($esgotado_found || $tente_found) {

                
                
                $historico->status = 'PROBLEMA';
                $historico->pk_loss = 100;
                $historico->tr_min = 0;
                $historico->tr_max = 0;
                $historico->tr_med = 0;

            } else {
                if (preg_match('/nimo\s*=\s*(\d+)/', $ping, $tr_min)) {$tr_min_value = intval($tr_min[1]);} else {$tr_min_value = 0;}

                if (preg_match('/ximo\s*=\s*(\d+)/', $ping, $tr_max)) {$tr_max_value = intval($tr_max[1]);} else {$tr_max_value = 0;}

                if (preg_match('/dia\s*=\s*(\d+)/', $ping, $tr_med)) {$tr_med_value = intval($tr_med[1]);} else {$tr_med_value = 0;}

                if (preg_match('/\((\d+%)\s+de\s+perda\)/', $ping, $pk_loss)) {$pk_loss_value = intval($pk_loss[1]);} else {$pk_loss_value = 0;}
                
                $historico->pk_loss = $pk_loss_value;
                $historico->tr_min = $tr_min_value;
                $historico->tr_max = $tr_max_value;
                $historico->tr_med = $tr_med_value;
                if($pk_loss_value == 100) {
                    $historico->status = 'PROBLEMA';
                } else {
                    $historico->status = 'ATIVO';
                }



                
            }

            $historico->save();

            foreach($portas as $porta) {

                if($porta->ativa) {
                    $porta_num = $porta->porta;
                    $historico_porta = new Historicoportas();
                    $historico_porta->porta_id = $porta->id;
                    $historico_porta->historico_id = $historico->id;

                    $socket = @fsockopen($ip, $porta_num, $errno, $errstr, 5);
                    if(!$socket || $socket == null){
                        $historico_porta->status = false;
                    } else {
                        $historico_porta->status = true;
                    }
                    $historico_porta->save();
                }
            }

            
            info($historico);

        }
    }

    info("segundo");
})->everyTenSeconds();

