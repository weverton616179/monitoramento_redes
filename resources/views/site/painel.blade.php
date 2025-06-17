@extends('site.layout')
@section('titulo', 'Painel')
@section('conteudo')

    <header class="flex justify-between	items-center m-2">

        <div class="flex">
            <button class="p-1 m-1 bg-red-400">
                <h1>PROBLEMAS: {{$hosts_pr->count()}}</h1>
            </button>
            <button class="p-1 m-1 bg-green-400">
                <h1>ATIVOS: {{$hosts_at->count()}}</h1>
            </button>
            <button class="p-1 m-1 bg-blue-400">
                <h1>NÃO MONITORADOS: {{$hosts_nm->count()}}</h1>
            </button>
            <button class="p-1 m-1 bg-gray-400">
                <h1>TODOS: {{$hosts_pr->count() + $hosts_at->count() + $hosts_nm->count() + $hosts_sh->count()}}</h1>
            </button>
        </div>

        <div class="">
            <h2 class="font-bold text-4xl">Monitoramento de redes</h2>
            <form action=""><input class="border border-transparent focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" type="text" name="" id="" placeholder="pesquisar"></form>
        </div>
        
        <div>
            
            @auth
                <a href="{{route('site.configuracoes')}}" class="p-1">configurações</a>
                <a href="{{route('site.porta')}}" class="p-1">adicionar porta</a>
                <a href="{{route('site.adicionar')}}" class="p-1">adicionar host</a>
                <a href="{{route('site.user.logout')}}" class="p-1">logout</a>
            @else
                <a href="{{route('site.user.login')}}" class="p-1">login</a>
            @endauth
            
            
        </div>
    </header>

    <main class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xlg:grid-cols-4 gap-2 mb-2">

        @foreach ($hosts_nm as $host)
            <div class="problems rounded-md bg-blue-300">
                <div class="nome text-center bg-blue-400">
                    <h2 class="text-lg font-semibold">{{$host->nome}}</h2>
                    <h2 class="text-md">{{$host->ip}}</h2>
                </div>
                <div class="pl-2 pt-2">
                    <p><span class="font-semibold">Status: </span>NÃO MONITORADA</p>
                    <p><span class="font-semibold">Packet Loss: </span>0%</p>
                    <p><span class="font-semibold">Tempo de resposta: </span>0/0/0ms</p>
                </div>

                <div class="pl-2 pt-2">
                    <h1 class="font-semibold">PORTAS</h1>
                    <div class="flex">
                        @foreach ($host->portas as $porta)
                            <?php $hporta = $porta->historicoportas->first()?>      
                                <div class="bg-blue-500 m-1">
                                    <a class="font-semibold" href="#">{{$porta->nome}}</a>
                                    <p class="center">NÃO MONITORADA</p>
                                </div>
                        @endforeach
                    </div>
                </div>

                <div class="right p-1">
                    <a class="font-semibold" href="{{route('site.historico', $host->id)}}">Histórico</a>
                </div>
            </div>
        @endforeach

        @foreach ($hosts_pr as $host)
            <?php $historico = $host->historicos->first()?>
            <div class="problems rounded-md bg-red-300">
                <div class="nome text-center bg-red-400">
                    <h2 class="text-lg font-semibold">{{$host->nome}}</h2>
                    <h2 class="text-md">{{$host->ip}}</h2>
                </div>
                <div class="pl-2 pt-2">
                    <p><span class="font-semibold">Status: </span>PROBLEMA DE CONEXÃO</p>
                    <p><span class="font-semibold">Packet Loss: </span>{{$historico->pk_loss}}%</p>
                    <p><span class="font-semibold">Tempo de resposta: </span>{{$historico->tr_min}}/{{$historico->tr_max}}/{{$historico->tr_med}}ms</p>
                </div>

                <div class="pl-2 pt-2">
                    <h1 class="font-semibold">PORTAS</h1>
                    <div class="flex">
                        @foreach ($host->portas as $porta)
                            
                            <?php $hporta = $porta->historicoportas->where('historico_id', $historico->id)->first()?>

                            @if ($porta->ativa)

                                @if ($hporta != null && $hporta->status)
                                    <div class="bg-green-500 m-1">
                                        <a class="font-semibold" href="#">{{$porta->nome}}</a>
                                        <p class="center">{{$porta->porta}}</p>
                                        <p class="center">ATIAVA</p>
                                    </div>
                                @elseif ($hporta != null && !$hporta->status)
                                    <div class="bg-red-500 m-1">
                                        <a class="font-semibold" href="#">{{$porta->nome}}</a>
                                        <p class="center">{{$porta->porta}}</p>
                                        <p class="center">PROBLEMA</p>
                                    </div>
                                @else
                                    <div class="bg-gray-500 m-1">
                                        <a class="font-semibold" href="#">{{$porta->nome}}</a>
                                        <p class="center">{{$porta->porta}}</p>
                                        <p class="center">S/HISTORICO</p>
                                    </div>
                                @endif
                                
                            @else

                                <div class="bg-blue-500 m-1">
                                    <a class="font-semibold" href="#">{{$porta->nome}}</a>
                                    <p class="center">NÃO MONITORADA</p>
                                </div>

                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="right p-1">
                    <a class="font-semibold" href="{{route('site.historico', $host->id)}}">Histórico</a>
                </div>
            </div>
        @endforeach

        @foreach ($hosts_at as $host)
            <?php
            $historico = $host->historicos->first();
            ?>
            <div class="problems rounded-md bg-green-300">
                <div class="nome text-center bg-green-400">
                    <h2 class="text-lg font-semibold">{{$host->nome}}</h2>
                    <h2 class="text-md">{{$host->ip}}</h2>
                </div>
                <div class="pl-2 pt-2">
                    <p><span class="font-semibold">Status: </span>CONEXÃO ATIVA</p>
                    <p><span class="font-semibold">Packet Loss: </span>{{$historico->pk_loss}}%</p>
                    <p><span class="font-semibold">Tempo de resposta: </span>{{$historico->tr_min}}/{{$historico->tr_max}}/{{$historico->tr_med}}ms</p>
                </div>
                <div class="pl-2 pt-2">
                    <h1 class="font-semibold">PORTAS</h1>
                    <div class="flex">
                        @foreach ($host->portas as $porta)
                            <?php $hporta = $porta->historicoportas->where('historico_id', $historico->id)->first()?>

                            @if ($porta->ativa)

                                @if ($hporta != null && $hporta->status)
                                    <div class="bg-green-500 m-1">
                                        <a class="font-semibold" href="#">{{$porta->nome}}</a>
                                        <p class="center">{{$porta->porta}}</p>
                                        <p class="center">ATIVA</p>
                                    </div>
                                @elseif ($hporta != null && !$hporta->status)
                                    <div class="bg-red-500 m-1">
                                        <a class="font-semibold" href="#">{{$porta->nome}}</a>
                                        <p class="center">{{$porta->porta}}</p>
                                        <p class="center">PROBLEMA</p>
                                    </div>
                                @else
                                    <div class="bg-gray-400 m-1">
                                        <a class="font-semibold" href="#">{{$porta->nome}}</a>
                                        <p class="center">{{$porta->porta}}</p>
                                        <p class="center">S/HISTORICO</p>
                                    </div>
                                @endif
                                
                            @else

                                <div class="bg-blue-500 m-1">
                                    <a class="font-semibold" href="#">{{$porta->nome}}</a>
                                    <p class="center">NÃO MONITORADA</p>
                                </div>

                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="right p-1">
                    <a class="font-semibold" href="{{route('site.historico', $host->id)}}">Histórico</a>
                </div>  
            </div>
        @endforeach

        @foreach ($hosts_sh as $host)
            <div class="problems rounded-md bg-gray-300">
                <div class="nome text-center bg-gray-400">
                    <h2 class="text-lg font-semibold">{{$host->nome}}</h2>
                    <h2 class="text-md">{{$host->ip}}</h2>
                </div>
                <div class="pl-2 pt-2">
                    <p><span class="font-semibold">Status: </span>SEM HISTÓRICO</p>
                    <p><span class="font-semibold">Packet Loss: </span>0%</p>
                    <p><span class="font-semibold">Tempo de resposta: </span>0/0/0ms</p>
                </div>

                <div class="pl-2 pt-2">
                    <h1 class="font-semibold">PORTAS</h1>
                    <div class="flex">
                        @foreach ($host->portas as $porta)
                            <?php $hporta = $porta->historicoportas->first()?>      
                            <div class="bg-gray-400 m-1">
                                <a class="font-semibold" href="#">{{$porta->nome}}</a>
                                <p class="center">{{$porta->porta}}</p>
                                <p class="center">S/HISTORICO</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach

    </main>
    

@endsection