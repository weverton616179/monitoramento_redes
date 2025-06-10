<?php

use App\Http\Controllers\HostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HostController::class,'index'])->name('site.home');
