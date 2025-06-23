@extends('site.layout')
@section('titulo', 'Cadastrar')
@section('conteudo')

    <section class="w-[40vw] m-auto my-5">
        <form action="{{route('user.store')}}" method="POST">
            @csrf
            <div class="py-1">
                <h1>nome</h1>
                <input class="border border-gray-600" type="text" name="name" required>
            </div>
            <div class="py-1">
                <h1>email</h1>
                <input class="border border-gray-600" type="email" name="email" required>
            </div>
            <div class="py-1">
                <h1>senha</h1>
                <input class="border border-gray-600" type="password" name="password" required>
            </div>
            <button class="bg-blue-400">Cadastrar</button>
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