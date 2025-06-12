<?php

use App\Http\Controllers\HostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return redirect()->route('site.painel');});

Route::get('/painel', [HostController::class,'index'])->name('site.painel');

Route::get('/adicionar', [HostController::class,'adicionar'])->name('site.adicionar');

Route::post('/adicionar/store', [HostController::class,'store'])->name('site.adicionar.store');

Route::get('/a', function() {
    // $host = \App\Models\Host::first();
    $user = \App\Models\User::first();
    

    dd($user->hosts);
    // $user->host()->attach($host);
});

