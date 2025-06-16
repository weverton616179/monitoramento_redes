<?php

namespace App\Http\Controllers;

use App\Models\Historico;
use App\Models\Host;
use App\Models\Porta;
use Illuminate\Http\Request;

class ConfiguracoesController extends Controller
{
    public function index() {
        $hosts = Host::all();

        return view("site.configuracoes", compact("hosts"));
    }

    public function editar($id) {
        $host = Host::find($id);
        $portas = Porta::where("host_id", $host->id)->get();

        return view("site.editar", compact("host","portas"));
    }

    public function editar_porta($id) {
        
        $porta = Porta::find($id);
        $host = Host::find($porta->host_id);

        return view("site.editar_porta", compact("porta", "host"));
    }

    public function historico($id) {
        $host = Host::find($id);
        $portas = Porta::where("host_id", $host->id)->get();
        $historicos = $host->historicos;
        return view("site.historico", compact("host","portas", "historicos"));
    }
}
