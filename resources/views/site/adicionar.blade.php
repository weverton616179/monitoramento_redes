@extends('site.layout')
@section('titulo', 'Adicionar')
@section('conteudo')

    <div class="container w-1/2 m-auto">
        <h1 class="font-bold w-1/2 m-auto text-4xl">Cadastro de Host</h1>
        <form action="{{route('site.adicionar.store')}}" method="POST" class="">
            @csrf
            <div>
                <h2>Nome</h2>
                <input name="nome" id="nome" type="text" class="border border-gray-600 bg-gray-200" required>
            </div>
            <div class="flex justify-between">
                <div class="m-1">
                    <h2>Endereço de IP</h2>
                    <input type="text" name="ip" id="ip" class="border border-gray-600 bg-gray-200" required>
                </div>
                <div class="m-1 mx-4">
                    <h2>Ativa</h2>
                    <input type="checkbox" name="ativa" id="ativa" checked>
                </div>
                <div class="m-1 mx-4">
                    <h2>Monitorar</h2>
                    <input type="checkbox" name="monitorar" id="monitorar" checked>
                </div>
            </div>

            <div class="flex justify-between">
                <div class="m-1">
                    <h2>Perda de pacotes (warning %)</h2>
                    <input type="number" name="perda_wng" id="perda_wng" class="border border-yellow-600 bg-yellow-200" required>
                </div>
                <div class="m-1">
                    <h2>Tempo de resposta (warning ms)</h2>
                    <input type="number" name="tempo_wng" id="tempo_wng" class="border border-yellow-600 bg-yellow-200" required>
                </div>
                <div class="m-1">
                    <h2>Perda de pacotes (critical %)</h2>
                    <input type="number" name="perda_crt" id="perda_crt" class="border border-red-600 bg-red-200" required>
                </div>
                <div class="m-1">
                    <h2>Tempo de resposta (critical ms)</h2>
                    <input type="number" name="tempo_crt" id="tempo_crt" class="border border-red-600 bg-red-200" required>
                </div>
            </div>

            <div class="">
                <h1 class="font-bold text-4xl py-[5vh]">Selecione as portas desejadas</h1>
                <div class="flex py-[1vh] justify-between">
                    <h1 class="font-bold w-[10vw]">Nome porta</h1>
                    <h1 class="font-bold w-[10vw]">Porta</h1>
                    <h1 class="font-bold w-[10vw]">Seleção</h1>
                </div>
                @foreach($portas as $porta)

                    <div class="flex py-[1vh] justify-between">
                        <h1 class="w-[10vw]">{{$porta->nome}}</h1>
                        <h1 class="w-[10vw]">{{$porta->porta}}</h1>
                        <input class="w-[10vw]" type="checkbox" name="portas[]" value="{{$porta->id}}" id="porta_{{$porta->id}}">
                    </div>

                @endforeach
            </div>

            <button class="bg-green-500 active:bg-green-700">Salvar</button>
        </form>
    </div>

@endsection