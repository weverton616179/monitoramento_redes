<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Host;
use App\Models\Porta;

class HostController extends Controller
{
    public function index(Request $request){

        $hosts_nm = Host::where('ativa', false)->get();

        $hosts_at = Host::where('ativa', true)->with('historicos')->get()->filter(function ($host) {
            return $host->historicos->first() && $host->historicos->first()->status == 'ATIVO';
        });

        $hosts_pr = Host::where('ativa', true)->with('historicos')->get()->filter(function ($host) {
            return $host->historicos->first() && $host->historicos->first()->status == 'PROBLEMA';
        });

        $hosts_sh = Host::where('ativa', true)->doesntHave('historicos')->get();

        return view("site.painel", compact("hosts_at", "hosts_pr", "hosts_nm", "hosts_sh"));
    }

    public function store(Request $request) {
        $host = ['nome' => $request->nome, 'ip' => $request->ip, 'ativa' => $request->ativa];
        $ativa = $request->has('ativa') ? true : false;
        $host['ativa'] = $ativa;
        $host_nova = Host::create($host);

        $portas_selecionadas = $request->input('portas', []);
        foreach($portas_selecionadas as $porta_id) {
            $porta = Porta::find($porta_id);
            $host_nova->portas()->attach($porta);
        }


        return redirect()->route('site.painel');
    }

    public function adicionar(Request $request) {
        $portas = Porta::all();
        return view("site.adicionar", compact('portas'));
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
        $host_up['ativa'] = $ativa;
        $host->update($host_up);

        $host->portas()->detach();
        $portas_selecionadas = $request->input('portas', []);
        foreach($portas_selecionadas as $porta_id) {
            $porta = Porta::find($porta_id);
            $host->portas()->attach($porta);
        }

        return redirect()->route("site.configuracoes");
    }
}