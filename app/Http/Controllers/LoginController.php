<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->route('site.painel');
        }
        return back()->withErrors(['email' => 'Senha ou e-mail incorreto!']);
    }

    public function cadastrar() {
        return view('site.create');
    }

    public function login() {
        return view("site.login");
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('site.painel');
    }
}
