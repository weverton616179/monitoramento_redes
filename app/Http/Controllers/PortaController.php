<?php

namespace App\Http\Controllers;

use App\Models\Host;
use App\Models\Porta;
use App\Models\Tempo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PortaController extends Controller
{
    public function index() {
        $hosts = Host::all();
        return view("site.porta",compact("hosts"));
    }

    public function store(Request $request) {
        $porta = ['ativa' => $request->ativa, 'nome' => $request->nome, 'porta' => $request->porta];

        $ativa = $request->has('ativa') ? true : false;
        $porta['ativa'] = $ativa;
        $porta_n = Porta::create($porta);

        $hosts_selecionadas = $request->input('hosts', []);
        foreach($hosts_selecionadas as $host_id) {
            $host = Host::find($host_id);
            $porta_n->host()->attach($host);
        }

        if(Tempo::where('tempo', $request->tempo)->first()) {
            $tempo = Tempo::where('tempo', $request->tempo)->first(); //mudar para find dps
            $porta_n->tempos()->attach($tempo);
        } else {
            $next_run_at = Carbon::now()->addMinutes(intval($request->tempo));
            $tempo = Tempo::create(['tempo' => $request->tempo, 'next_run_at' => $next_run_at]);
            $porta_n->tempos()->attach($tempo);
        }
        
        return redirect()->route('site.painel');
    }

    public function destroy($id) {
        $porta = Porta::find($id);
        $porta->delete();
        return redirect()->route("site.configuracoes");
    }

    public function update($id, Request $request) {
        $porta = Porta::find($id);
        $porta_up = $request->all();
        $ativa = $request->has('ativa') ? true : false;
        $porta_up['ativa'] = $ativa;
        $porta->update($porta_up);

        $porta->host()->detach();
        $hosts_selecionadas = $request->input('hosts', []);
        foreach($hosts_selecionadas as $host_id) {
            $host = Host::find($host_id);
            $porta->host()->attach($host);
        }

        $porta->tempos()->detach();
        if(Tempo::where('tempo', $request->tempo)->first()) {
            $tempo = Tempo::where('tempo', $request->tempo)->first(); //mudar para find dps
            $porta->tempos()->attach($tempo);
        } else {
            $next_run_at = Carbon::now()->addMinutes(intval($request->tempo));
            $tempo = Tempo::create(['tempo' => $request->tempo, 'next_run_at' => $next_run_at]);
            $porta->tempos()->attach($tempo);
        }


        return redirect()->route("site.configuracoes");
    }

    public function editar_porta($id) {
        $hosts = Host::all();
        $porta = Porta::find($id);
        $tempo = $porta->tempos()->first();
        return view("site.editar_porta", compact("porta", "hosts", "tempo"));
    }
}
