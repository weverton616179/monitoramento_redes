@extends('site.layout')
@section('titulo', 'Home')
@section('conteudo')

    <header class="nav-wrapper container">
        <h3 class="left ">Monitoramento de redes</h3>
        
        <a href="" class="right">login</a>

        @foreach ($collection as $item)
            
        @endforeach
    </header>

@endsection