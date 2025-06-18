@extends('site.layout')
@section('titulo', 'Porta')
@section('conteudo')

    <div class="container w-1/2 m-auto">
        <h1 class="font-bold w-1/2 m-auto text-4xl">Cadastro de Porta</h1>
        <form action="{{route('site.porta.store')}}" method="POST" class="">
            @csrf
            <div class="flex justify-between">
                <div>
                    <h2>nome Porta</h2>
                    <input class="border border-gray-600 bg-gray-200" name="nome" id="nome" type="text">
                </div>
            </div>
            <div class="flex justify-between">
                <div class="m-1">
                    <h2>Porta</h2>
                    <input class="border border-gray-600 bg-gray-200" type="text" name="porta" id="porta">
                </div>
                <div class="m-1 mx-4">
                    <h2>Monitorando</h2>
                    <input type="checkbox" name="ativa" id="ativa" >
                </div>
            </div>

            <div class="">
                <h1 class="font-bold text-4xl py-[5vh]">Atrelar as hosts</h1>
                <div class="flex py-[1vh] justify-between">
                    <h1 class="font-bold w-[10vw]">Nome host</h1>
                    <h1 class="font-bold w-[10vw]">host</h1>
                    <h1 class="font-bold w-[10vw]">Atrelar</h1>
                </div>
                @foreach($hosts as $host)

                    <div class="flex py-[1vh] justify-between">
                        <h1 class="w-[10vw]">{{$host->nome}}</h1>
                        <h1 class="w-[10vw]">{{$host->ip}}</h1>
                        <input class="w-[10vw]" type="checkbox" name="hosts[]" value="{{$host->id}}" id="host_{{$host->id}}">
                    </div>

                @endforeach
            </div>

            <button class="bg-green-500 active:bg-green-700">Salvar</button>
        </form>
    </div>

@endsection