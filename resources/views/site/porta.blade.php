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
                    <input name="nome" id="nome" type="text">
                </div>
                {{-- <div>
                    <label for="names">Escolha uma Host:</label>
                    <select id="host_id" name="host_id">
                        @foreach($hosts as $host) {
                            <option id="host_id" value="{{$host->id}}">{{$host->nome}}</option>
                        } 
                        @endforeach
                    </select>
                </div> --}}
            </div>
            <div class="flex justify-between">
                <div class="m-1">
                    <h2>Porta</h2>
                    <input type="text" name="porta" id="porta">
                </div>
                <div class="m-1 mx-4">
                    <h2>Monitorando</h2>
                    <input type="checkbox" name="ativa" id="ativa" >
                </div>
            </div>
            <button class="bg-green-500 active:bg-green-700">Salvar</button>
        </form>
    </div>

@endsection