<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    

    public function store(Request $request) 
    {
        $user = $request->all();
        $user["password"] = bcrypt($request->password);
        $user = User::create($user);

        Auth::login($user);
        return redirect()->route('site.painel');
    }
}
