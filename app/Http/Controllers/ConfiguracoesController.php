<?php

namespace App\Http\Controllers;

use App\Models\Historico;
use App\Models\Host;
use App\Models\Porta;
use Illuminate\Http\Request;
use Carbon\Carbon;


class ConfiguracoesController extends Controller
{
    public function index() {
        $hosts = Host::all();
        $portas = Porta::all();
        return view("site.configuracoes", compact("hosts", "portas"));
    }

    public function editar($id) {
        $host = Host::find($id);
        $portas = Porta::all();
        // $portas = Porta::where("host_id", $host->id)->get();

        return view("site.editar", compact("host","portas"));
    }

    public function editar_porta($id) {
        $hosts = Host::all();
        $porta = Porta::find($id);
        return view("site.editar_porta", compact("porta", "hosts"));
    }

    public function historico($id) {
        $host = Host::find($id);
        $portas = $host->portas;
        $historicosAsc = $host->historicosAsc()->get();
        $historicos = $host->historicos;

        $quantia = $historicosAsc->count();
        $tempo_at = 0;
        $tempo_wr = 0;
        $tempo_pr = 0;

        for($i = 0; $i<$quantia-1 ; $i++) {
            $historico_atual = $historicosAsc->get($i);
            $historico_prox = $historicosAsc->get($i+1);

            
            $data1 = Carbon::parse($historico_atual->created_at);
            $data2 = Carbon::parse($historico_prox->created_at);
            $tempo = $data1->diffInHours($data2);

            if($historico_atual->status == "ATIVO") {
                $tempo_at = $tempo_at + $tempo;
            } elseif($historico_atual->status == "WARNING") {
                $tempo_wr = $tempo_wr + $tempo;
            } elseif($historico_atual->status == "PROBLEMA") {
                $tempo_pr = $tempo_pr + $tempo;
            }
        }

        $tempo_total = $tempo_at + $tempo_wr + $tempo_pr;

        return view("site.historico", compact("host","portas", "historicos", "tempo_at", "tempo_wr", "tempo_pr", "tempo_total"));
    }
}
