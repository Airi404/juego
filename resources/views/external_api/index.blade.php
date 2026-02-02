@extends('layouts.base')

@section('content')
<div class="max-w-5xl mx-auto mt-10 px-4">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        
        <div class="bg-slate-800 p-5 rounded-3xl border border-slate-700 h-[600px] flex flex-col shadow-xl">
            <h3 class="text-indigo-400 font-black uppercase text-[10px] tracking-widest mb-4">Índice Pokémon</h3>
            <div class="overflow-y-auto pr-2 custom-scrollbar space-y-1">
                @foreach($pokemonList as $name)
                    <a href="{{ route('api.external', ['pokemon' => $name]) }}" 
                       class="block text-slate-400 hover:text-white hover:bg-indigo-600/20 px-3 py-2 rounded-xl text-sm capitalize transition-all border border-transparent hover:border-indigo-500/30">
                        {{ $loop->iteration }}. {{ $name }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="md:col-span-3">
            <div class="text-center mb-10">
                <h1 class="text-white font-black uppercase italic text-4xl mb-6 tracking-tighter">
                    Poke<span class="text-indigo-500">Master</span> API
                </h1>

                <form action="{{ route('api.external') }}" method="GET" class="relative max-w-xl mx-auto">
                    <input type="text" name="pokemon" value="{{ request('pokemon') }}" placeholder="Escribe el nombre de un Pokémon..." 
                        class="w-full bg-slate-900 border-2 border-slate-700 rounded-2xl px-6 py-4 text-white focus:border-indigo-500 outline-none shadow-2xl transition-all">
                    <button type="submit" class="absolute right-3 top-3 bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-2 rounded-xl font-black uppercase text-xs">
                        Buscar
                    </button>
                </form>
            </div>

            @if(isset($apiData))
                <div class="bg-indigo-600/5 border-2 border-indigo-500 p-10 rounded-[50px] shadow-2xl relative overflow-hidden backdrop-blur-sm">
                    <div class="absolute top-6 right-8 flex gap-2">
                        @foreach($apiData['types'] as $type)
                            <span class="bg-indigo-500 text-white text-[10px] font-black uppercase px-4 py-1 rounded-full shadow-lg">
                                {{ $type['type']['name'] }}
                            </span>
                        @endforeach
                    </div>

                    <img src="{{ $apiData['sprites']['other']['official-artwork']['front_default'] }}" 
                         class="w-56 h-56 mx-auto drop-shadow-[0_0_25px_rgba(79,70,229,0.6)] hover:scale-105 transition-transform">
                    
                    <h2 class="text-white font-black text-5xl uppercase italic mt-6 tracking-tighter">{{ $apiData['name'] }}</h2>
                    
                    <div class="grid grid-cols-2 gap-6 mt-8">
                        <div class="bg-slate-900/80 p-5 rounded-3xl border border-slate-700">
                            <p class="text-indigo-400 text-[10px] font-black uppercase tracking-widest mb-1">Altura</p>
                            <p class="text-white text-2xl font-bold italic">{{ $apiData['height'] / 10 }} m</p>
                        </div>
                        <div class="bg-slate-900/80 p-5 rounded-3xl border border-slate-700">
                            <p class="text-indigo-400 text-[10px] font-black uppercase tracking-widest mb-1">Peso</p>
                            <p class="text-white text-2xl font-bold italic">{{ $apiData['weight'] / 10 }} kg</p>
                        </div>
                    </div>
                </div>

            @elseif(isset($suggestion))
                <div class="bg-slate-800 border-2 border-amber-500/50 p-10 rounded-[50px] shadow-xl text-center">
                    <div class="text-amber-500 mb-4 flex justify-center">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <p class="text-slate-400 font-bold uppercase tracking-widest text-sm italic">No encontramos a "{{ $search }}"</p>
                    <h3 class="text-2xl text-white mt-4">
                        ¿Quizás quisiste decir 
                        <a href="{{ route('api.external', ['pokemon' => $suggestion]) }}" 
                           class="text-amber-500 font-black underline italic decoration-amber-500/30 hover:text-amber-400 transition-colors">
                            {{ $suggestion }}
                        </a>?
                    </h3>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection