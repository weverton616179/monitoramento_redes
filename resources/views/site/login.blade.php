@extends('site.layout')
@section('titulo', 'Login')
@section('conteudo')

    <section class="w-[40vw] m-auto my-5">
        <form action="{{route('login.auth')}}" method="POST">
            @csrf
            <div class="py-1">
                <h1>email</h1>
                <input class="border border-gray-600" type="email" name="email" placeholder="ex@email.com" required>
            </div>
            <div class="py-1">
                <h1>senha</h1>
                <input class="border border-gray-600" type="password" name="password" required>
            </div>
            <button class="bg-green-400">Entrar</button>
        </form>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-red-600">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </section>

@endsection