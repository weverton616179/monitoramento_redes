<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;


class UserController extends Controller
{
    

    public function store(Request $request) 
    {
        
        try {
            $user = $request->all();
            $user["password"] = bcrypt($request->password);
            $user = User::create($user);

            Auth::login($user);
            return redirect()->route('site.painel');
        } catch (QueryException  $e) {
            if ($e->errorInfo[1] == 1062) {
                return back()->withErrors(['email' => 'Este e-mail já está cadastrado.']);
            }
            return redirect()->route('site.painel');
        }
    }

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
