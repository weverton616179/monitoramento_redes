@extends('site.layout')
@section('titulo', 'Editar')
@section('conteudo')

<a href="{{route('site.configuracoes')}}" class=" "><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#00AAAA"><path d="m370-80-16-128q-13-5-24.5-12T307-235l-119 50L78-375l103-78q-1-7-1-13.5v-27q0-6.5 1-13.5L78-585l110-190 119 50q11-8 23-15t24-12l16-128h220l16 128q13 5 24.5 12t22.5 15l119-50 110 190-103 78q1 7 1 13.5v27q0 6.5-2 13.5l103 78-110 190-118-50q-11 8-23 15t-24 12L590-80H370Zm70-80h79l14-106q31-8 57.5-23.5T639-327l99 41 39-68-86-65q5-14 7-29.5t2-31.5q0-16-2-31.5t-7-29.5l86-65-39-68-99 42q-22-23-48.5-38.5T533-694l-13-106h-79l-14 106q-31 8-57.5 23.5T321-633l-99-41-39 68 86 64q-5 15-7 30t-2 32q0 16 2 31t7 30l-86 65 39 68 99-42q22 23 48.5 38.5T427-266l13 106Zm42-180q58 0 99-41t41-99q0-58-41-99t-99-41q-59 0-99.5 41T342-480q0 58 40.5 99t99.5 41Zm-2-140Z"/></svg></a>


    <div class="container w-1/2 m-auto">
        <h1 class="font-bold w-1/2 m-auto my-[6vh] text-4xl">Editar Host</h1>
        <form action="{{route('site.host.update', $host->id)}}" method="POST" class="">
            @csrf
            <div class="flex justify-between">
                <div class="m-1">
                    <h2>Nome</h2>
                    <input name="nome" id="nome" type="text" value="{{$host->nome}}" class="border border-gray-600 bg-gray-200" required>
                </div>
            </div>
            <div class="flex justify-between">
                <div class="m-1">
                    <h2>Endereço de IP</h2>
                    <input type="text" name="ip" id="ip" value="{{$host->ip}}" class="border border-black bg-gray-200">
                </div>
                <div class="m-1 mx-4">
                    <h2>Ativa</h2>
                    @if ($host->ativa)
                        <input type="checkbox" name="ativa" id="ativa" checked>
                    @else
                        <input type="checkbox" name="ativa" id="ativa" >
                    @endif
                </div>
                <div class="m-1 mx-4">
                    <h2>Monitorar</h2>
                    @if ($host->monitorar)
                        <input type="checkbox" name="monitorar" id="monitorar" checked>
                    @else
                        <input type="checkbox" name="monitorar" id="monitorar" >
                    @endif
                </div>
            </div>

            <div class="flex justify-between">
                <div class="m-1">
                    <h2>Perda de pacotes (warning %)</h2>
                    <input type="number" name="perda_wng" id="perda_wng" class="border border-yellow-600 bg-yellow-200" required value="{{$host->perda_wng}}">
                </div>
                <div class="m-1">
                    <h2>Tempo de resposta (warning ms)</h2>
                    <input type="number" name="tempo_wng" id="tempo_wng" class="border border-yellow-600 bg-yellow-200" required value="{{$host->tempo_wng}}">
                </div>
                <div class="m-1">
                    <h2>Perda de pacotes (critical %)</h2>
                    <input type="number" name="perda_crt" id="perda_crt" class="border border-red-600 bg-red-200" required value="{{$host->perda_crt}}">
                </div>
                <div class="m-1">
                    <h2>Tempo de resposta (critical ms)</h2>
                    <input type="number" name="tempo_crt" id="tempo_crt" class="border border-red-600 bg-red-200" required value="{{$host->tempo_crt}}">
                </div>
            </div>

            <div class="">
                <h1 class="font-bold text-4xl py-[5vh]">Selecione as portas desejadas</h1>
                <div class="flex py-[1vh] justify-between">
                    <h1 class="font-bold w-[10vw]">Nome porta</h1>
                    <h1 class="font-bold w-[10vw]">Porta</h1>
                    <h1 class="font-bold w-[20vw]">Tempo entre verificações (minutos)</h1>
                    <h1 class="font-bold w-[10vw]">Seleção</h1>
                </div>
                @foreach($portas as $porta)

                    <div class="flex py-[1vh] justify-between">
                        <h1 class="w-[10vw]">{{$porta->nome}}</h1>
                        <h1 class="w-[10vw]">{{$porta->porta}}</h1>
                        @if ($host->portas()->where('portas.id', $porta->id)->exists())
                            <div class="w-[20vw] m-1">
                                <input name="tempos[]" id="tempo_{{$porta->id}}" type="number" value="{{$host->portas->find($porta->id)->pivot->where('porta_id', $porta->id)->first()->tempo}}" class="border border-gray-600 bg-gray-200" required>
                            </div>
                            <input class="w-[10vw]" type="checkbox" name="portas[]" value="{{$porta->id}}" id="porta_{{$porta->id}}" checked onchange="toggleTimeInput(this)">
                        @else
                            <div class="w-[20vw] m-1">
                                <input name="tempos[]" id="tempo_{{$porta->id}}" type="number" value="1" class="border border-gray-600 bg-gray-200" required disabled>
                            </div>
                            <input class="w-[10vw]" type="checkbox" name="portas[]" value="{{$porta->id}}" id="host_{{$porta->id}}" onchange="toggleTimeInput(this)">
                        @endif
                    </div>

                @endforeach
            </div>
            
            <button class="bg-green-500 active:bg-green-700">Salvar</button>
        </form>
    </div>
    <script>
        function toggleTimeInput(checkbox) {
            const portaId = checkbox.id.split('_')[1];
            const timeInput = document.getElementById('tempo_' + portaId);
            if(checkbox.checked == true) {
                timeInput.disabled = false;
            } else {
                timeInput.disabled = true;
            }
            // timeInput.disabled = !checkbox.checked;
        }
    </script>

@endsection