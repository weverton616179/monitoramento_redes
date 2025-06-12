@extends('site.layout')
@section('titulo', 'Adicionar')
@section('conteudo')

    <div class="container w-1/2 m-auto">
        <h1 class="font-bold w-1/2 m-auto text-4xl">Cadastro de Host</h1>
        <form action="{{route('site.adicionar.store')}}" method="POST" class="">
            @csrf
            <div>
                <h2>Nome</h2>
                <input name="nome" id="nome" type="text">
            </div>
            <div class="flex justify-between">
                <div class="m-1">
                    <h2>Endereço de IP</h2>
                    <input type="text" name="ip" id="ip">
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