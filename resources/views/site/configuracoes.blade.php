@extends('site.layout')
@section('titulo', 'Configurações')
@section('conteudo')
    <main class="w-[90vw] m-auto mt-[3vw]">
        <a href="{{route('site.painel')}}"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#00AAAA"><path d="M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm-80 80v-480l320-240 320 240v480H520v-240h-80v240H160Zm320-350Z"/></svg></a>
        <section class="flex justify-between my-2">
            <h1 class="font-bold text-2xl">Lista de Hosts</h1>
            <div>
                <p>pesquisar: <input class="border border-black" type="text" id="busca"></p>
            </div>
        </section>
        <section>
            <div class="flex justify-between my-3">
                <h1 class="w-[10vw] m-auto font-bold">NOME</h1>
                <h1 class="w-[10vw] m-auto font-bold">IP</h1>

                <h1 class="w-[10vw] m-auto font-bold">WARNING LOSS</h1>
                <h1 class="w-[10vw] m-auto font-bold">CRITICAL LOSS</h1>
                <h1 class="w-[10vw] m-auto font-bold">WARNING TIME</h1>
                <h1 class="w-[10vw] m-auto font-bold">CRITICAL TIME</h1>

                <h1 class="w-[5vw] m-auto font-bold">ATIVA</h1>
                <h1 class="w-[10vw] m-auto font-bold">MONITORANDO</h1>
                <h1 class="w-[10vw] m-auto font-bold">AÇÕES</h1>
            </div>
            <ul id="hostsUl">
            @foreach($hosts as $host)
                <li class="flex justify-between mt-2">
                    <h1 class="w-[10vw] m-auto">{{$host->nome}}</h1>
                    <h1 class="w-[10vw] m-auto">{{$host->ip}}</h1>

                    <h1 class="w-[10vw] m-auto">{{$host->perda_wng}}</h1>
                    <h1 class="w-[10vw] m-auto">{{$host->perda_crt}}</h1>
                    <h1 class="w-[10vw] m-auto">{{$host->tempo_wng}}</h1>
                    <h1 class="w-[10vw] m-auto">{{$host->tempo_crt}}</h1>

                    <div class="w-[5vw] m-auto">
                        @if ($host->ativa)
                            <input type="checkbox" checked disabled>
                        @else
                            <input type="checkbox" disabled>
                        @endif
                    </div>
                    <div class="w-[10vw] m-auto">
                        @if ($host->monitorar)
                            <input type="checkbox" checked disabled>
                        @else
                            <input type="checkbox" disabled>
                        @endif
                    </div>
                    <div class="w-[10vw] m-auto flex">
                        <form action="{{route('site.host.delete', $host->id)}}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#00AAAA"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg></button>
                        </form>

                        <a href="{{route('site.adicionar', $host->id)}}"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#00AAAA"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg></a>
                        <a href="{{route('site.historico', $host->id)}}"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#00AAAA"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg></a>
                        
                    </div>
                </li>
            @endforeach
            </ul>
        </section>


        <section class="py-[6vh]">
            <h1 class="font-bold text-2xl">Lista de Portas</h1>
            <div class="flex justify-between my-3">
                <h1 class="w-[30vw] m-auto font-bold">NOME PORTA</h1>
                <h1 class="w-[30vw] m-auto font-bold">PORTA</h1>
                <h1 class="w-[10vw] m-auto font-bold">MONITORANDO</h1>
                <h1 class="w-[10vw] m-auto font-bold">AÇÕES</h1>
            </div>
            <ul id="portasUl">
            @foreach($portas as $porta)
                <li class="flex justify-between mt-2">
                    <h1 class="w-[30vw] m-auto">{{$porta->nome}}</h1>
                    <h1 class="w-[30vw] m-auto">{{$porta->porta}}</h1>
                    <div class="w-[10vw] m-auto">
                        @if ($porta->ativa)
                            <input type="checkbox" checked disabled>
                        @else
                            <input type="checkbox" disabled>
                        @endif
                    </div>
                    <div class="w-[10vw] m-auto flex">
                        <form action="{{route('site.porta.delete', $porta->id)}}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#00AAAA"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg></button>
                        </form>

                        <a href="{{route('site.porta.editar', $porta->id)}}"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#00AAAA"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg></a>
                        
                    </div>
                </li>
            @endforeach
            </ul>
        </section>
    </main>

    <script>

        document.getElementById('busca').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const lists = [
                document.getElementById('hostsUl'), 
                document.getElementById('portasUl')
            ];
            
            lists.forEach(list => {
                const items = list.getElementsByTagName('li');
                
                for (let i = 0; i < items.length; i++) {
                    const h1Elements = items[i].getElementsByTagName('h1');
                    const nome = h1Elements[0].textContent.toLocaleLowerCase();
                    const ip = h1Elements[1].textContent.toLocaleLowerCase();
                    
                    if (nome.includes(searchTerm) || ip.includes(searchTerm)) {
                        items[i].style.display = 'flex';
                    } else {
                        items[i].style.display = 'none';
                    }
                }
            });
        });
        
    </script>
@endsection