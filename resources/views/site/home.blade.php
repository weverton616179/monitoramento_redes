@extends('site.layout')
@section('titulo', 'Home')
@section('conteudo')

    <header class="flex">
        <h3 class="">Monitoramento de redes</h3>
        
        <a href="" class="">login</a>
    </header>

    <main class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xlg:grid-cols-4 gap-2 mb-2">

        @foreach ($hosts as $host)
        
            @if ($host->ativa)
                @if ($host->historico_recente->status == 'ATIVO')
                
                @endif
                
                <div class="problems rounded-md bg-green-300">
                    <div class="nome text-center bg-green-400">
                        <h2 class="text-lg font-semibold">{{$host->nome}}</h2>
                        <h2 class="text-md">{{$host->ip}}</h2>
                    </div>
                    <div class="pl-2 pt-2">
                        <p><span class="font-semibold">Status: </span>A</p>
                        <p><span class="font-semibold">Packet Loss: </span>%</p>
                        <p><span class="font-semibold">Tempo de resposta: </span>0/0/0ms</p>
                    </div>
                    <div>
                        <a class="font-semibold" href="#">Histórico</a>
                    </div>
                </div>
                
            @else
                
                <div class="problems rounded-md bg-green-300">
                    <div class="nome text-center bg-green-400">
                        <h2 class="text-lg font-semibold">{{$host->nome}}</h2>
                        <h2 class="text-md">{{$host->ip}}</h2>
                    </div>
                    <div class="pl-2 pt-2">
                        <p><span class="font-semibold">Status: </span>Não monitorada</p>
                        <p><span class="font-semibold">Packet Loss: </span>0%</p>
                        <p><span class="font-semibold">Tempo de resposta: </span>0/0/0ms</p>
                    </div>
                    <div>
                        <a class="font-semibold" href="#">Histórico</a>
                    </div>
                </div>
                
            @endif

            
            
        @endforeach

    </main>
    

@endsection