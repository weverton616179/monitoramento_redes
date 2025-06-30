@extends('site.layout')
@section('titulo', 'Historico')
@section('conteudo')

    <main>
        <a href="{{route('site.painel')}}"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#00AAAA"><path d="M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm-80 80v-480l320-240 320 240v480H520v-240h-80v240H160Zm320-350Z"/></svg></a>
        <section class="w-[20vw] m-auto my-[5vh]">
            @php $historico_first = $historicos->first(); @endphp
            @if ($historico_first)
                <h1 class="font-semibold">{{$host->nome}}</h1>
                <h3 class="font-semibold">{{$host->ip}}</h3>
                @if (!$host->monitorar)
                    <h3 class="font-semibold text-blue-600">NÃO MONITORADA</h3>
                @elseif ($historico_first == null)
                    <h3 class="font-semibold">SEM HISTORICO</h3>
                @elseif ($historico_first->status == "ATIVO")
                    <h3 class="font-semibold text-green-600">ATIVO</h3>
                @elseif ($historico_first->status == "PROBLEMA")
                    <h3 class="font-semibold text-red-600">PROBLEMA</h3>
                @elseif ($historico_first->status == "WARNING")
                    <h3 class="font-semibold text-yellow-600">WARNING</h3>
                @endif
                <p><span class="font-semibold">Packet Loss: </span>{{$historico_first->pk_loss}}%</p>
                <p><span class="font-semibold">Tempo de resposta: </span>{{$historico_first->tr_min}}/{{$historico_first->tr_max}}/{{$historico_first->tr_med}}ms</p>
            @else    
                <h1 class="font-semibold">{{$host->nome}}</h1>
                <h3 class="font-semibold">{{$host->ip}}</h3>
                <h3 class="font-semibold">SEM HISTORICO</h3>
            @endif
        </section>

        <section class="my-[40px] h-[30vh]">
            <div class="py-5">
                <h1 class="font-bold w-[50vw] m-auto text-center">Tempo total {{floor($tempo_total)}}h {{floor(($tempo_total - floor($tempo_total)) * 60)}}m</h1>
                <h1 class="w-[50vw] m-auto text-center">Tempo <a class="text-green-600">ativo</a> {{floor($tempo_at)}}h {{floor(($tempo_at - floor($tempo_at)) * 60)}}m</h1>
                <h1 class="w-[50vw] m-auto text-center">Tempo <a class="text-yellow-600">warning</a> {{floor($tempo_wr)}}h {{floor(($tempo_wr - floor($tempo_wr)) * 60)}}m</h1>
                <h1 class="w-[50vw] m-auto text-center">Tempo <a class="text-red-600">problema</a> {{floor($tempo_pr)}}h {{floor(($tempo_pr - floor($tempo_pr)) * 60)}}m</h1>
            </div>
            <div class="w-[90vw] h-[8vh] m-auto">
                <div id="graficoTres"></div>
            </div>
        </section>
        <section>
            <h1 class="font-bold w-[50vw] m-auto text-center">Tempo de resposta (ms)</h1>
            <div id="grafico" class="w-[90vw] h-[30vh] m-auto"></div>
        </section>
        <section class="my-[40px]">
            <h1 class="font-bold w-[50vw] m-auto text-center">Perda de pacote (%)</h1>
            <div id="graficoDois" class="w-[90vw] h-[30vh] m-auto"></div>
        </section>
        
        @foreach ($portas as $porta)
            <section class="my-[40px] h-[30vh]">
                <h1 class="font-bold w-[50vw] m-auto text-center">grafico {{$porta->nome}}</h1>
                <div class="w-[90vw] h-[8vh] m-auto">
                    <div id="grafico_{{$porta->id}}"></div>
                </div>
            </section>
        @endforeach

        <section class="flex mx-5 justify-between">
            <div class="w-[60vw] py-[30px]">
                <h1 class="w-[10vw] font-bold m-auto py-3">Host</h1>
                <div class="flex">
                    <h1 class="w-[15vw] font-bold">Data</h1>
                    <h1 class="w-[15vw] font-bold">Status</h1>
                    <h1 class="w-[15vw] font-bold">Packet Loss (%)</h1>
                    <h1 class="w-[15vw] font-bold">Response Time (ms)</h1>
                </div>

                @foreach ($historicos->chunk(20) as $chunk)  
                    @foreach ($chunk as $historico)

                        <div class="flex my-3">
                            <h1 class="w-[15vw] ">{{$historico->updated_at}}</h1>
                            @if ($historico->status == "ATIVO")
                                <h1 class="w-[15vw] font-semibold text-green-600">ATIVO</h1>
                            @elseif ($historico->status == "PROBLEMA")
                                <h1 class="w-[15vw] font-semibold text-red-600">PROBLEMA</h1>
                            @elseif ($historico->status == "WARNING")
                                <h1 class="w-[15vw] font-semibold text-yellow-600">WARNING</h1>
                            @endif
                            <h1 class="w-[15vw] ">{{$historico->pk_loss}}%</h1>
                            <h1 class="w-[15vw] ">{{$historico->tr_min}}/{{$historico->tr_max}}/{{$historico->tr_med}}ms</h1>
                        </div>
                        
                    @endforeach
                @endforeach   
            </div>

            <div class="w-[30vw]">
                <h1 class="w-[10vw] font-bold m-auto py-3">Portas</h1>
                <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 justify-evenly">
                    @foreach ($portas as $porta)
                        <?php $historicoportas = $porta->historicoportas->where('host_id', $host->id)->first() ?>
                        @if ($historicoportas->status == 1)
                            <button class="w-[80px] h-[80px] bg-green-300 flex items-center justify-center hover:bg-green-400 relative " onclick="ver(this)">
                                
                        @else
                            <button class="w-[80px] h-[80px] flex items-center justify-center bg-red-300 hover:bg-red-400 relative " onclick="ver(this)">
                            
                        @endif
                                <h1 class="font-semibold">{{$porta->nome}}</h1>
                                <div class="hidden absolute bottom-[70px] left-[-50%] bg-gray-300">
                                    <h1 class="w-[10vw]">{{$historicoportas->created_at}}</h1>
                                    @if ($historicoportas->status == 1)
                                        <h1 class="w-[5vw] font-semibold text-green-600">ATIVA</h1>
                                    @else
                                        <h1 class="w-[5vw] font-semibold text-red-600">PROBLEMA</h1>
                                    @endif
                                </div>
                            </button>
                        
                        {{-- <div>
                            <h1 class="w-[5vw] font-bold m-auto py-3">{{$porta->nome}}</h1>
                            <div class="flex">
                                <h1 class="w-[10vw] font-bold m-auto py-3">Data</h1>
                                <h1 class="w-[5vw] font-bold m-auto py-3">Status</h1>
                            </div>
                            @foreach ($porta->historicoportas->where('host_id', $host->id) as $historicoportas)
                                <div class="flex">
                                    <h1 class="w-[10vw]">{{$historicoportas->created_at}}</h1>
                                    @if ($historicoportas->status == 1)
                                        <h1 class="w-[5vw] font-semibold text-green-600">ATIVA</h1>
                                    @else
                                        <h1 class="w-[5vw] font-semibold text-red-600">PROBLEMA</h1>
                                    @endif
                                    
                                </div>
                            @endforeach
                        </div> --}}
                    @endforeach
                </div>
            </div>
            
        </section>
        
    </main>
    
    <script>
        function ver(botao) {
            const div = botao.getElementsByTagName('div');
            if(div.style.dispay == 'none') {
                div.style.display = "block";
            }
        }
    </script>

    <script>
        var historicos = @json($historicosAsc);

        var pk_loss = [];
        var tr_max = [];
        var tr_med = [];
        var tr_min = [];
        var updated_at = [];
        var estatus = [];
        historicos.forEach(historico => {
            pk_loss.push(historico.pk_loss);
            tr_max.push(historico.tr_max);
            tr_med.push(historico.tr_med);
            tr_min.push(historico.tr_min);
            updated_at.push(historico.updated_at.split('T')[1].split('.')[0]);
            if(historico.status == "ATIVO") {
                estatus.push(1);
            } else if (historico.status == "WARNING") {
                estatus.push(2);
            } else {
                estatus.push(3);
            }
        });

        var options = {
        chart: {
            type: 'line',
            width: '100%',
            height: '100%' 
        },
        series: [
            {
                name: 'Tempo de resposta médio',
                data: tr_med
            },
            {
                name: 'Tempo de resposta minimo',
                data: tr_min
            },
            {
                name: 'Tempo de resposta máximo',
                data: tr_max
            }
        ],
        xaxis: {
            categories: updated_at,
            tickAmount: 30
        }
        }

        var optionsDois = {
        chart: {
            type: 'line',
            width: '100%',
            height: '100%' 
        },
        series: [
            {
                name: 'Perda de pacote (%)',
                data: pk_loss
            },
        ],
        xaxis: {
            categories: updated_at,
            tickAmount: 30
        }
        }

        var optionsTres = {
        series: [{
            name: "Desktops",
            data: estatus.map((status, index) => {
                return {
                    x: index + 1, // ou seus rótulos
                    y: status,
                    fillColor: status === 1 ? '#00ee00' : 
                            status === 2 ? '#ffff00' : 
                            status === 3 ? '#ff0000' : '#cccccc'
                };
            })
        }],
        chart: {
            width: '100%',
            height: '100%',
            type: 'bar',
            stacked: true,
            stackType: "100%",
            sparkline: {
                enabled: true
            }
          
        },
        plotOptions: {
            bar: {
                columnWidth: '100%',
                horizontal: false,
            }, 
        },
        dataLabels: {
            enabled: false
        },
        states: {
            hover: {
                filter: {
                    type: 'none' // Remove efeito hover
                }
            },
            active: {
                filter: {
                    type: 'none' // Remove efeito de clique
                }
            }
        },
        tooltip: {
            enabled: false
        }
        };

        var chart = new ApexCharts(document.querySelector("#grafico"), options);
        var chartDois = new ApexCharts(document.querySelector("#graficoDois"), optionsDois);
        var chartTres = new ApexCharts(document.querySelector("#graficoTres"), optionsTres);

        chart.render();
        chartDois.render();
        chartTres.render();
    </script>

    @foreach ($portas as $porta)
        <script>
            var host = @json($host);
            var porta = @json($porta->with('historicoportas')->find($porta->id));
            
            var estatus = [];
            porta.historicoportas.forEach(historico => {
                if(historico.host_id == host.id) {
                    estatus.push(historico.status + 1);
                }

            });

            var options = {
            series: [{
                name: "Desktops",
                data: estatus.map((status, index) => {
                    return {
                        x: index + 1, // ou seus rótulos
                        y: status,
                        fillColor: status === 2 ? '#00ee00' : 
                            status === 1 ? '#ff0000' : '#cccccc'
                    };
                })
            }],
            chart: {
                width: '100%',
                height: '100%',
                type: 'bar',
                stacked: true,
                stackType: "100%",
                sparkline: {
                    enabled: true
                }
            
            },
            plotOptions: {
                bar: {
                    columnWidth: '100%',
                    horizontal: false,
                }, 
            },
            dataLabels: {
                enabled: false
            },
            states: {
                hover: {
                    filter: {
                        type: 'none' // Remove efeito hover
                    }
                },
                active: {
                    filter: {
                        type: 'none' // Remove efeito de clique
                    }
                }
            },
            tooltip: {
                enabled: false
            }
            };

            var chart = new ApexCharts(document.querySelector("#grafico_" + porta.id), options);
            chart.render();
        </script>
    @endforeach 

@endsection