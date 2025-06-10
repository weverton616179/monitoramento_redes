<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HostController extends Controller
{
    function index(Request $request){
        return view("site.home");
    }
}
