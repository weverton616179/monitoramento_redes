<?php

use App\Http\Controllers\ConfiguracoesController;
use App\Http\Controllers\HostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PortaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return redirect()->route('site.painel');});

Route::get('/painel', [HostController::class,'index'])->name('site.painel');

Route::get('/adicionar', [HostController::class,'adicionar'])->name('site.adicionar');

Route::post('/adicionar/store', [HostController::class,'store'])->name('site.adicionar.store');

Route::get('/porta', [PortaController::class,'index'])->name('site.porta');

Route::POST('/porta/store', [PortaController::class,'store'])->name('site.porta.store');

Route::get('/configuracoes', [ConfiguracoesController::class,'index'])->name('site.configuracoes');

Route::delete('/host/delete/{id}', [HostController::class,'destroy'])->name('site.host.delete');

Route::delete('/porta/delete/{id}', [PortaController::class,'destroy'])->name('site.porta.delete');

Route::get('/host/editar/{id}', [ConfiguracoesController::class,'editar'])->name('site.host.editar');

Route::get('/porta/editar/{id}', [ConfiguracoesController::class,'editar_porta'])->name('site.porta.editar');

Route::post('/host/update/{id}', [HostController::class,'update'])->name('site.host.update');

Route::post('/porta/update/{id}', [PortaController::class,'update'])->name('site.porta.update');

Route::get('/historico/{id}', [ConfiguracoesController::class,'historico'])->name('site.historico');

Route::get('/login', [UserController::class, 'login'])->name('site.user.login');

Route::post('/auth', [LoginController::class,'authenticate'])->name('login.auth');

Route::get('/cadastrar', [LoginController::class,'cadastrar'])->name('login.cadastrar');

Route::post('/user/store', [UserController::class,'store'])->name("user.store");

Route::get('/a', function() {
    // $host = \App\Models\Host::first();
    $user = \App\Models\User::first();
    

    dd($user->hosts);
    // $user->host()->attach($host);
});

