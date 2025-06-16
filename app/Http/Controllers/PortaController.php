<?php

namespace App\Http\Controllers;

use App\Models\Host;
use App\Models\Porta;
use Illuminate\Http\Request;

class PortaController extends Controller
{
    public function index() {
        $hosts = Host::all();
        return view("site.porta",compact("hosts"));
    }

    public function store(Request $request) {
        $porta = $request->all();

        $ativa = $request->has('ativa') ? true : false;
        $porta['ativa'] = $ativa;
        Porta::create($porta);
        return redirect()->route('site.painel');
    }

    public function destroy($id) {
        $porta = Porta::find($id);
        $porta->delete();
        return redirect()->route("site.host.editar", $porta->host_id);
    }

    public function update($id, Request $request) {
        $porta = Porta::find($id);
        $porta_up = $request->all();
        $ativa = $request->has('ativa') ? true : false;
        $porta_up['ativa'] = $ativa;
        $porta->update($porta_up);
        return redirect()->route("site.host.editar", $porta->host_id);
    }
}
