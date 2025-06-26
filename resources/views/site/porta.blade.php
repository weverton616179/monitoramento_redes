@extends('site.layout')
@section('titulo', 'Porta')
@section('conteudo')

<a href="{{route('site.painel')}}" class=" "><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#00AAAA"><path d="M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm-80 80v-480l320-240 320 240v480H520v-240h-80v240H160Zm320-350Z"/></svg></a>

    <div class="container w-1/2 m-auto">
        <h1 class="font-bold w-1/2 m-auto text-4xl">Cadastro de Porta</h1>
        <form action="{{route('site.porta.store')}}" method="POST" class="">
            @csrf
            <div class="flex justify-between">
                <div>
                    <h2>nome Porta</h2>
                    <input class="border border-gray-600 bg-gray-200" name="nome" id="nome" type="text">
                </div>
                <div class="m-1">
                    <h2>Tempo entre verificações (minutos)</h2>
                    <input name="tempo" id="tempo" type="number" class="border border-gray-600 bg-gray-200" required>
                </div>
            </div>
            <div class="flex justify-between">
                <div class="m-1">
                    <h2>Porta</h2>
                    <input class="border border-gray-600 bg-gray-200" type="text" name="porta" id="porta">
                </div>
                <div class="m-1 mx-4">
                    <h2>Monitorando</h2>
                    <input type="checkbox" name="ativa" id="ativa" checked>
                </div>
            </div>

            <div class="">
                <h1 class="font-bold text-4xl py-[5vh]">Atrelar as hosts</h1>
                <div class="flex py-[1vh] justify-between">
                    <h1 class="font-bold w-[20vw]">Nome host</h1>
                    <h1 class="font-bold w-[10vw]">host</h1>
                    <h1 class="font-bold w-[10vw]">Atrelar</h1>
                </div>
                @foreach($hosts as $host)

                    <div class="flex py-[1vh] justify-between">
                        <h1 class="w-[20vw]">{{$host->nome}}</h1>
                        <h1 class="w-[10vw]">{{$host->ip}}</h1>
                        <input class="w-[10vw]" type="checkbox" name="hosts[]" value="{{$host->id}}" id="host_{{$host->id}}">
                    </div>

                @endforeach
            </div>

            <button class="bg-green-500 active:bg-green-700">Salvar</button>
        </form>
    </div>

@endsection