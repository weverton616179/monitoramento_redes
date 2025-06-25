<?php

use App\Http\Controllers\ConfiguracoesController;
use App\Http\Controllers\HostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PortaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

use Acamposm\Ping\Ping;
use Acamposm\Ping\PingCommandBuilder;
use App\Models\Host;
use Carbon\Carbon;

Route::get('/', function () { return redirect()->route('site.painel');});
Route::get('/painel', [HostController::class,'index'])->name('site.painel');
Route::get('/historico/{id}', [HostController::class,'historico'])->name('site.historico');


Route::controller(UserController::class)->prefix('user')->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/auth', 'authenticate')->name('login.auth');
    Route::get('/cadastrar', 'cadastrar')->name('login.cadastrar');
    Route::post('/store', 'store')->name("user.store");
    Route::get('/logout', 'logout')->name('site.user.logout')->middleware("auth");
});

Route::controller(HostController::class)->prefix('host')->middleware("auth")->group(function () {
    Route::get('/configuracoes','configuracoes')->name('site.configuracoes');
    Route::get('/adicionar/{id?}', 'adicionar')->name('site.adicionar');
    Route::post('/store', 'store')->name('site.adicionar.store');
    Route::delete('/delete/{id}', 'destroy')->name('site.host.delete');
    // Route::get('/editar/{id}', 'editar')->name('site.host.editar');
    Route::post('/update/{id}', 'update')->name('site.host.update');
});

Route::controller(PortaController::class)->prefix('porta')->middleware("auth")->group(function () {
    Route::get('/adicionar', 'index')->name('site.porta');
    Route::POST('/store', 'store')->name('site.porta.store');
    Route::get('/editar/{id}', 'editar_porta')->name('site.porta.editar');
    Route::post('/update/{id}', 'update')->name('site.porta.update');
    Route::delete('/delete/{id}', 'destroy')->name('site.porta.delete');
});

Route::get('/a', function() {
    $host = Host::first();
    $now = Carbon::now();

    $diff = $now->diffInHours($host->createdAt);
    dd($diff);
    //a cada um minuto executar o schedule, pegaro historico mais recente da host, e verificar se já passou do tempo com o dif, caso sim cria um novo job.
});