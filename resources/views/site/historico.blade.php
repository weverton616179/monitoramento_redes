@extends('site.layout')
@section('titulo', 'Historico')
@section('conteudo')

    <main>
        <section class="w-[20vw] m-auto my-[5vh]">
            @php $historico_first = $historicos->first(); @endphp
            <h1 class="font-semibold">{{$host->nome}}</h1>
            <h3 class="font-semibold">{{$host->ip}}</h3>
            @if (!$host->ativa)
                <h3 class="font-semibold">NÃO MONITORADA</h3>
            @elseif ($historico_first == null)
                <h3 class="font-semibold">SEM HISTORICO</h3>
            @elseif ($historico_first->status == "ATIVO")
                <h3 class="font-semibold">ATIVO</h3>
            @elseif ($historico_first->status == "PROBLEMA")
                <h3 class="font-semibold">PROBLEMA</h3>
            @endif
            <p><span class="font-semibold">Packet Loss: </span>{{$historico_first->pk_loss}}%</p>
            <p><span class="font-semibold">Tempo de resposta: </span>{{$historico_first->tr_min}}/{{$historico_first->tr_max}}/{{$historico_first->tr_med}}ms</p>
        </section>
        <section class="w-[90vw] m-auto ">
            <div class="flex">
                <h1 class="w-[10vw] font-bold">Data</h1>
                <h1 class="w-[10vw] font-bold">Status</h1>
                <h1 class="w-[10vw] font-bold">Packet Loss (%)</h1>
                <h1 class="w-[10vw] font-bold">Response Time (ms)</h1>
                <h1 class="w-[10vw] font-bold">Portas</h1>
            </div>
            @foreach ($historicos as $historico)

                <div class="flex my-3">
                    <h1 class="w-[10vw] ">{{$historico->updated_at}}</h1>
                    @if ($historico->ativo)
                        <h1 class="w-[10vw] ">ATIVO</h1>
                    @else
                        <h1 class="w-[10vw] ">PROBLEMA</h1>
                    @endif
                    <h1 class="w-[10vw] ">{{$historico->pk_loss}}%</h1>
                    <h1 class="w-[10vw] ">{{$historico->tr_min}}/{{$historico->tr_max}}/{{$historico->tr_med}}ms</h1>
                    @foreach ($historico->historicoportas as $historicoportas)
                        <div class="mx-2">
                            <h1>{{$historicoportas->porta->nome}}</h1>
                            @if ($historicoportas->status)
                                <p>ATIVO {{$historicoportas->id}}</p>
                            @else
                                <p>PROBLEMA {{$historicoportas->id}}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
                
            @endforeach

            
        </section>
    </main>

@endsection