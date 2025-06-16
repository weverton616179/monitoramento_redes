@extends('site.layout')
@section('titulo', 'Editar Porta')
@section('conteudo')

    <div class="container w-1/2 m-auto">
        <h1 class="font-bold w-1/2 m-auto text-4xl">Edição de Porta</h1>
        <form action="{{route('site.porta.update', $porta->id)}}" method="POST" class="">
            @csrf
            <input type="hidden" name="host_id" value="{{$host->id}}">
            <div class="flex justify-between">
                <div>
                    <h2>nome Porta</h2>
                    <input name="nome" id="nome" type="text" value="{{$porta->nome}}">
                </div>
            </div>
            <div class="flex justify-between">
                <div class="m-1">
                    <h2>Porta</h2>
                    <input type="text" name="porta" id="porta" value="{{$porta->porta}}">
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
            <button class="bg-green-500 active:bg-green-700">Salvar</button>
        </form>
    </div>

@endsection