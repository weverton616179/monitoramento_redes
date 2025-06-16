@extends('site.layout')
@section('titulo', 'Cadastrar')
@section('conteudo')

    <section class="w-[40vw] m-auto my-5">
        <form action="{{route('user.store')}}" method="POST">
            @csrf
            <div class="py-1">
                <h1>nome</h1>
                <input type="text" name="name">
            </div>
            <div class="py-1">
                <h1>email</h1>
                <input type="email" name="email">
            </div>
            <div class="py-1">
                <h1>senha</h1>
                <input type="password" name="password">
            </div>
            <button class="bg-blue-400">Cadastrar</button>
        </form>
    </section>

@endsection