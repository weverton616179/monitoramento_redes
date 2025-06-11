<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Host;

class HostController extends Controller
{
    function index(Request $request){
        $hosts = Host::all();

        return view("site.home", compact("hosts"));
    }
}
