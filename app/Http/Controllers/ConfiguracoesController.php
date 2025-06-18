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
        $historicos = $host->historicos;
        return view("site.historico", compact("host","portas", "historicos"));
    }
}
