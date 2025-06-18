@extends('site.layout')
@section('titulo', 'Historico')
@section('conteudo')

    <main>
        <section class="w-[20vw] m-auto my-[5vh]">
            @php $historico_first = $historicos->first(); @endphp
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
                    @if ($historico->status == "ATIVO")
                        <h1 class="w-[10vw] font-semibold text-green-600">ATIVO</h1>
                    @elseif ($historico->status == "PROBLEMA")
                        <h1 class="w-[10vw] font-semibold text-red-600">PROBLEMA</h1>
                    @elseif ($historico->status == "WARNING")
                        <h1 class="w-[10vw] font-semibold text-yellow-600">WARNING</h1>
                    @endif
                    <h1 class="w-[10vw] ">{{$historico->pk_loss}}%</h1>
                    <h1 class="w-[10vw] ">{{$historico->tr_min}}/{{$historico->tr_max}}/{{$historico->tr_med}}ms</h1>
                    @foreach ($historico->historicoportas as $historicoportas)
                        <div class="mx-2">
                            <h1>{{$historicoportas->porta->nome}}</h1>
                            @if ($historicoportas->status)
                                <p class="font-semibold text-green-600">ATIVO</p>
                            @else
                                <p class="font-semibold text-red-600">PROBLEMA</p>
                            @endif
                        </div>
                    @endforeach
                </div>
                
            @endforeach

            
        </section>
    </main>

@endsection