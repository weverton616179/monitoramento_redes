<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Host;

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
        $host = $request->all();
        $ativa = $request->has('ativa') ? true : false;
        $host['ativa'] = $ativa;
        Host::create($host);
        return redirect()->route('site.painel');
    }

    public function adicionar(Request $request) {
        
        return view("site.adicionar");
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
        return redirect()->route("site.configuracoes");
    }
}