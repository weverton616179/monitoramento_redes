@extends('site.layout')
@section('titulo', 'Editar')
@section('conteudo')

    <div class="container w-1/2 m-auto">
        <h1 class="font-bold w-1/2 m-auto my-[6vh] text-4xl">Editar Host</h1>
        <form action="{{route('site.host.update', $host->id)}}" method="POST" class="">
            @csrf
            <div>
                <h2>Nome</h2>
                <input name="nome" id="nome" type="text" value="{{$host->nome}}" class="border border-black bg-gray-200">
            </div>
            <div class="flex justify-between">
                <div class="m-1">
                    <h2>Endereço de IP</h2>
                    <input type="text" name="ip" id="ip" value="{{$host->ip}}" class="border border-black bg-gray-200">
                </div>
                <div class="m-1 mx-4">
                    <h2>Ativa</h2>
                    @if ($host->ativa)
                        <input type="checkbox" name="ativa" id="ativa" checked>
                    @else
                        <input type="checkbox" name="ativa" id="ativa" >
                    @endif
                </div>
                <div class="m-1 mx-4">
                    <h2>Monitorar</h2>
                    @if ($host->monitorar)
                        <input type="checkbox" name="monitorar" id="monitorar" checked>
                    @else
                        <input type="checkbox" name="monitorar" id="monitorar" >
                    @endif
                </div>
            </div>

            <div class="flex justify-between">
                <div class="m-1">
                    <h2>Perda de pacotes (warning %)</h2>
                    <input type="number" name="perda_wng" id="perda_wng" class="border border-yellow-600 bg-yellow-200" required value="{{$host->perda_wng}}">
                </div>
                <div class="m-1">
                    <h2>Tempo de resposta (warning ms)</h2>
                    <input type="number" name="tempo_wng" id="tempo_wng" class="border border-yellow-600 bg-yellow-200" required value="{{$host->tempo_wng}}">
                </div>
                <div class="m-1">
                    <h2>Perda de pacotes (critical %)</h2>
                    <input type="number" name="perda_crt" id="perda_crt" class="border border-red-600 bg-red-200" required value="{{$host->perda_crt}}">
                </div>
                <div class="m-1">
                    <h2>Tempo de resposta (critical ms)</h2>
                    <input type="number" name="tempo_crt" id="tempo_crt" class="border border-red-600 bg-red-200" required value="{{$host->tempo_crt}}">
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
                        @if ($host->portas()->where('portas.id', $porta->id)->exists())
                            <input class="w-[10vw]" type="checkbox" name="portas[]" value="{{$porta->id}}" id="porta_{{$porta->id}}" checked>
                        @else
                            <input class="w-[10vw]" type="checkbox" name="portas[]" value="{{$porta->id}}" id="porta_{{$porta->id}}">
                        @endif
                    </div>

                @endforeach
            </div>
            
            <button class="bg-green-500 active:bg-green-700">Salvar</button>
        </form>
    </div>

@endsection