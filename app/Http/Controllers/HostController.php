<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Host;
use App\Models\Porta;
use Carbon\Carbon;

class HostController extends Controller
{
    public function index(Request $request){
        $hosts = Host::where('ativa', true)->get(); 

        $hosts_nm = $hosts->filter( function($host) {
            return !$host->monitorar;
        });

        $hosts_sh = $hosts->filter(function($host) {
            return $host->monitorar && !$host->historicos->first();
        });

        $hosts_at = $hosts->filter( function($host) {
            return $host->monitorar && $host->historicos->first() && $host->historicos->first()->status == 'ATIVO';
        });
        
        $hosts_wng = $hosts->filter( function($host) {
            return $host->monitorar && $host->historicos->first() && $host->historicos->first()->status == 'WARNING';
        });

        $hosts_pr = $hosts->filter( function($host) {
            return $host->monitorar && $host->historicos->first() && $host->historicos->first()->status == 'PROBLEMA';
        });

        return view("site.painel", compact("hosts_at", "hosts_pr", "hosts_nm", "hosts_sh", "hosts_wng"));
    }

    public function store(Request $request) {
        $host = ['nome' => $request->nome, 'ip' => $request->ip, 'ativa' => $request->ativa, 'monitorar' => $request->monitorar, 'perda_wng' => $request->perda_wng, 'perda_crt' => $request->perda_crt, 'tempo_wng' => $request->tempo_wng, 'tempo_crt' => $request->tempo_crt];
        $ativa = $request->has('ativa') ? true : false;
        $monitorar = $request->has('monitorar') ? true : false;
        $host['ativa'] = $ativa;
        $host['monitorar'] = $monitorar;
        $host_nova = Host::create($host);

        $portas_selecionadas = $request->input('portas', []);
        foreach($portas_selecionadas as $porta_id) {
            $porta = Porta::find($porta_id);
            $host_nova->portas()->attach($porta);
        }


        return redirect()->route('site.painel');
    }

    public function adicionar(?int $id = null) {

        if($id == null) {
            $portas = Porta::all();
            return view("site.adicionar", compact('portas'));
        } else {
            $host = Host::find($id);
            $portas = Porta::all();

            return view("site.editar", compact("host","portas"));
        }
        
    }

    public function destroy($id) {
        $host = Host::find($id);
        $host->delete();
        return redirect()->route("site.configuracoes");
    }

    public function update($id, Request $request) {
        $host = Host::find($id);
        $host_up = $request->all();
        $ativa = $request->has('ativa') ? true : false;
        $monitorar = $request->has('monitorar') ? true : false;
        $host_up['ativa'] = $ativa;
        $host_up['monitorar'] = $monitorar;
        $host->update($host_up);

        $host->portas()->detach();
        $portas_selecionadas = $request->input('portas', []);
        foreach($portas_selecionadas as $porta_id) {
            $porta = Porta::find($porta_id);
            $host->portas()->attach($porta);
        }

        return redirect()->route("site.configuracoes");
    }

    // public function editar($id) {
    //     $host = Host::find($id);
    //     $portas = Porta::all();

    //     return view("site.editar", compact("host","portas"));
    // }

    public function configuracoes() {
        $hosts = Host::all();
        $portas = Porta::all();
        return view("site.configuracoes", compact("hosts", "portas"));
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

        return view("site.historico", compact("host","portas", "historicos", "tempo_at", "tempo_wr", "tempo_pr", "tempo_total", "historicosAsc"));
    }
}