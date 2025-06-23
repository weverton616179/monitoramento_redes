@extends('site.layout')
@section('titulo', 'Painel')
@section('conteudo')

    <header class="flex justify-between	items-center m-2">

        <div class="flex">
            <button class="p-1 m-1 bg-red-400">
                <h1 id="botaoProblemas" class="font-semibold">PROBLEMAS: {{$hosts_pr->count()}}</h1>
            </button>
            <button class="p-1 m-1 bg-green-400">
                <h1 id="botaoAtivos" class="font-semibold">ATIVOS: {{$hosts_at->count()}}</h1>
            </button>
            <button class="p-1 m-1 bg-yellow-300">
                <h1 id="botaoWarning" class="font-semibold">WARNING: {{$hosts_wng->count()}}</h1>
            </button>
            <button class="p-1 m-1 bg-blue-400">
                <h1 id="botaoNm" class="font-semibold">NÃO MONITORADOS: {{$hosts_nm->count()}}</h1>
            </button>
            <button class="p-1 m-1 bg-gray-400">
                <h1 id="botaoTodos" class="font-semibold">TODOS: {{$hosts_pr->count() + $hosts_at->count() + $hosts_nm->count() + $hosts_sh->count() + $hosts_wng->count()}}</h1>
            </button>
        </div>

        <div class="">
            <h2 class="font-bold text-4xl">Monitoramento de redes</h2>
            <form action=""><input class="border focus:outline-none focus:ring-2 focus:ring-purple-600 border-gray-600 bg-gray-100 " type="text" name="busca" id="busca" placeholder="pesquisar"></form>
        </div>
        
        <div>
            
            @auth
                <a href="{{route('site.configuracoes')}}" class="p-1">configurações</a>
                <a href="{{route('site.porta')}}" class="p-1">adicionar porta</a>
                <a href="{{route('site.adicionar')}}" class="p-1">adicionar host</a>
                <a href="{{route('site.user.logout')}}" class="p-1">logout</a>
            @else
                <a href="{{route('login')}}" class="p-1">login</a>
            @endauth
            
            
        </div>
    </header>

    <main>
        <ul id="sectionNm" class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xlg:grid-cols-4 gap-2 mb-2">
            @foreach ($hosts_nm as $host)
                <li class="problems rounded-md bg-blue-300">
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
                </li>
            @endforeach
            </ul>
        
        <ul id="sectionProblemas" class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xlg:grid-cols-4 gap-2 mb-2">
            @foreach ($hosts_pr as $host)
                <?php $historico = $host->historicos->first()?>
                <li class="problems rounded-md bg-red-300">
                    <div class="nome text-center bg-red-400">
                        <h2 class="titulo-host text-lg font-semibold">{{$host->nome}}</h2>
                        <h2 class="ip-host text-md">{{$host->ip}}</h2>
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
                                
                                <?php $hporta = $porta->historicoportas->where('historico_id', $historico->id)->first();
                                    if($hporta == null) {
                                        $aa = $host->historicos->skip(1)->first();
                                        if($aa != null){
                                            $hporta = $porta->historicoportas->where('historico_id', $aa->id)->first();
                                        } 
                                    }
                                ?>

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
                </li>
            @endforeach
            </ul>
      
        <ul id="sectionWarning" class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xlg:grid-cols-4 gap-2 mb-2">
            @foreach ($hosts_wng as $host)
                <?php
                $historico = $host->historicos->first();
                ?>
                <li class="problems rounded-md bg-yellow-100">
                    <div class="nome text-center bg-yellow-200">
                        <h2 class="text-lg font-semibold">{{$host->nome}}</h2>
                        <h2 class="text-md">{{$host->ip}}</h2>
                    </div>
                    <div class="pl-2 pt-2">
                        <p><span class="font-semibold">Status: </span>WARNING</p>
                        <p><span class="font-semibold">Packet Loss: </span>{{$historico->pk_loss}}%</p>
                        <p><span class="font-semibold">Tempo de resposta: </span>{{$historico->tr_min}}/{{$historico->tr_max}}/{{$historico->tr_med}}ms</p>
                    </div>
                    <div class="pl-2 pt-2">
                        <h1 class="font-semibold">PORTAS</h1>
                        <div class="flex">
                            @foreach ($host->portas as $porta)
                                <?php $hporta = $porta->historicoportas->where('historico_id', $historico->id)->first();
                                    if($hporta == null) {
                                        $aa = $host->historicos->skip(1)->first();
                                        if($aa != null){
                                            $hporta = $porta->historicoportas->where('historico_id', $aa->id)->first();
                                        } 
                                    }
                                ?>

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
                </li>
            @endforeach
            </ul>

        <ul id="sectionAtivos" class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xlg:grid-cols-4 gap-2 mb-2">
            @foreach ($hosts_at as $host)
                <?php
                $historico = $host->historicos->first();
                ?>
                <li class="problems rounded-md bg-green-300">
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
                                <?php $hporta = $porta->historicoportas->where('historico_id', $historico->id)->first();
                                    if($hporta == null) {
                                        $aa = $host->historicos->skip(1)->first();
                                        if($aa != null){
                                            $hporta = $porta->historicoportas->where('historico_id', $aa->id)->first();
                                        } 
                                    }
                                ?>

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
                </li>
            @endforeach
            </ul>
        
        <ul id="sectionSh" class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xlg:grid-cols-4 gap-2 mb-2">
            @foreach ($hosts_sh as $host)
                <li class="problems rounded-md bg-gray-300">
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
                </li>
            @endforeach
        </ul>
    </main>

    <script>

        document.getElementById('busca').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const lists = [
                document.getElementById('sectionProblemas'), 
                document.getElementById('sectionNm'),
                document.getElementById('sectionWarning'),
                document.getElementById('sectionAtivos'),
                document.getElementById('sectionSh')
            ];
            
            document.getElementById('sectionProblemas').style.display = 'grid';
            document.getElementById('sectionNm').style.display = 'grid';
            document.getElementById('sectionWarning').style.display = 'grid';
            document.getElementById('sectionAtivos').style.display = 'grid';
            document.getElementById('sectionSh').style.display = 'grid';
            lists.forEach(list => {
                const items = list.getElementsByTagName('li');
                
                for (let i = 0; i < items.length; i++) {
                    const h2Elements = items[i].getElementsByTagName('h2');
                    const nome = h2Elements[0].textContent.toLocaleLowerCase();
                    const ip = h2Elements[1].textContent.toLocaleLowerCase();
                    
                    if (nome.includes(searchTerm) || ip.includes(searchTerm)) {
                        items[i].style.display = 'list-item';
                    } else {
                        items[i].style.display = 'none';
                    }
                }
            });
        });
        
    </script>
    <script>
        const sectionProblemas = document.getElementById('sectionProblemas');
        const sectionNm = document.getElementById('sectionNm');
        const sectionWarning = document.getElementById('sectionWarning');
        const sectionAtivos = document.getElementById('sectionAtivos');
        const sectionSh = document.getElementById('sectionSh');

        const botaoProblemas = document.getElementById('botaoProblemas')
        const botaoAtivos = document.getElementById('botaoAtivos')
        const botaoWarning = document.getElementById('botaoWarning')
        const botaoNm = document.getElementById('botaoNm')
        const botaoTodos = document.getElementById('botaoTodos')

        botaoProblemas.addEventListener('click', () => {
            sectionProblemas.style.display = 'grid';
            sectionNm.style.display = 'none';
            sectionWarning.style.display = 'none';
            sectionAtivos.style.display = 'none';
            sectionSh.style.display = 'none';
        });

        botaoAtivos.addEventListener('click', () => {
            sectionProblemas.style.display = 'none';
            sectionNm.style.display = 'none';
            sectionWarning.style.display = 'none';
            sectionAtivos.style.display = 'grid';
            sectionSh.style.display = 'none';
        });

        botaoWarning.addEventListener('click', () => {
            sectionProblemas.style.display = 'none';
            sectionNm.style.display = 'none';
            sectionWarning.style.display = 'grid';
            sectionAtivos.style.display = 'none';
            sectionSh.style.display = 'none';
        });

        botaoNm.addEventListener('click', () => {
            sectionProblemas.style.display = 'none';
            sectionNm.style.display = 'grid';
            sectionWarning.style.display = 'none';
            sectionAtivos.style.display = 'none';
            sectionSh.style.display = 'none';
        });

        botaoTodos.addEventListener('click', () => {
            sectionProblemas.style.display = 'grid';
            sectionNm.style.display = 'grid';
            sectionWarning.style.display = 'grid';
            sectionAtivos.style.display = 'grid';
            sectionSh.style.display = 'grid';
        });

    </script>
    <script>
        const busca = document.getElementById('busca');
        const valor = localStorage.getItem('inputValue');
        busca.value = valor;
        setTimeout(() => {
            // Código que executa após a espera
        }, 2000);
        console.log(valor);


        busca.getElementById('busca').addEventListener('input', function() {
            console.log(this.value);
            localStorage.setItem('inputValue', this.value);
        });
    </script>
    {{-- <script>
        setTimeout(function() {
            window.location.reload();
        }, 15000);
    </script> --}}
    

@endsection