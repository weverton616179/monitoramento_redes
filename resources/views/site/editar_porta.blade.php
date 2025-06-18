@extends('site.layout')
@section('titulo', 'Editar Porta')
@section('conteudo')

    <div class="container w-1/2 m-auto">
        <h1 class="font-bold w-1/2 m-auto text-4xl">Edição de Porta</h1>
        <form action="{{route('site.porta.update', $porta->id)}}" method="POST" class="">
            @csrf
            {{-- <input type="hidden" name="host_id" value="{{$host->id}}"> --}}
            <div class="flex justify-between">
                <div>
                    <h2>nome Porta</h2>
                    <input name="nome" id="nome" type="text" value="{{$porta->nome}}" class="border border-gray-600 bg-gray-200">
                </div>
            </div>
            <div class="flex justify-between">
                <div class="m-1">
                    <h2>Porta</h2>
                    <input type="text" name="porta" id="porta" value="{{$porta->porta}}" class="border border-gray-600 bg-gray-200">
                </div>
                <div class="m-1 mx-4">
                    <h2>Monitorando</h2>
                    @if ($porta->ativa)
                        <input type="checkbox" name="ativa" id="ativa" checked>
                    @else
                        <input type="checkbox" name="ativa" id="ativa" >
                    @endif
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
                        @if ($porta->host()->where('hosts.id', $host->id)->exists())
                            <input class="w-[10vw]" type="checkbox" name="hosts[]" value="{{$host->id}}" id="host_{{$host->id}}" checked>
                        @else
                            <input class="w-[10vw]" type="checkbox" name="hosts[]" value="{{$host->id}}" id="host_{{$host->id}}">
                        @endif
                    </div>

                @endforeach
            </div>

            <button class="bg-green-500 active:bg-green-700">Salvar</button>
        </form>
    </div>

@endsection