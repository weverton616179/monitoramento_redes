<?php

use App\Http\Controllers\HostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HostController::class,'index'])->name('site.home');

Route::get('/a', function() {
    // $host = \App\Models\Host::first();
    $user = \App\Models\User::first();
    

    dd($user->hosts);
    // $user->host()->attach($host);
});

