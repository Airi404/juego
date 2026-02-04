@extends('layouts.base') @section('title', 'Bienvenido a PixelNexus')

@section('content')
<div class="relative overflow-hidden pt-16 pb-32">
    <div class="container mx-auto px-6 relative z-10">
        <div class="flex flex-col items-center text-center">
            <span class="text-indigo-500 font-bold tracking-widest uppercase text-sm mb-4">Red Social & Tienda Gamer</span>
            <h1 class="text-6xl md:text-8xl font-black mb-6 bg-gradient-to-r from-white to-slate-500 bg-clip-text text-transparent">
                CONECTA. JUEGA. <br> <span class="text-indigo-600">EVOLUCIONA.</span>
            </h1>
            
            <p class="text-xl text-slate-400 max-w-2xl mb-10">
                La plataforma definitiva para gestionar tu inventario, conectar con tu squad y dominar el mercado de items digitales.
            </p>

            <div class="flex flex-col items-center bg-slate-900 p-8 rounded-3xl border border-slate-800 shadow-2xl transition-all hover:border-indigo-500/50">
    
            <div class="w-32 h-32 rounded-full border-4 border-indigo-600 shadow-indigo-500/40 shadow-2xl mb-4 
                        bg-gradient-to-tr from-indigo-900 via-indigo-600 to-purple-500 
                        flex items-center justify-center">
                <span class="text-white text-5xl font-black tracking-tighter drop-shadow-lg">
                    {{ substr("Iria", 0, 1) }}
                </span>
            </div>

            <h3 class="text-2xl font-bold italic tracking-tight">
                Desarrollado por: <span class="text-indigo-400">Iria</span>
            </h3>
            
            <div class="mt-2 flex items-center space-x-2">
                <span class="px-2 py-0.5 bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 text-[10px] uppercase font-bold rounded">2° DAW</span>
                <p class="text-slate-500 text-sm">Back-End Developer</p>
            </div>
        </div>

            <div class="mt-12 flex gap-4">
                <a href="/tienda" class="bg-indigo-600 hover:bg-indigo-500 px-8 py-4 rounded-2xl font-bold text-lg transition-all transform hover:scale-105">
                    Ir a la Tienda
                </a>
                <a href="/external-api" class="bg-slate-800 hover:bg-slate-700 px-8 py-4 rounded-2xl font-bold text-lg transition-all">
                    Ver pokemons
                </a>
                <a href="/chatbot" class="bg-slate-800 hover:bg-slate-700 px-8 py-4 rounded-2xl font-bold text-lg transition-all">
                    Probar IA
                </a>
            </div>
            
        </div>
    </div>
</div>
<section class="mt-10">
    <h2 class="text-3xl font-bold mb-6 text-indigo-400">Comunidad Registrada</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($persons as $person)
            <a href="{{ route('person.show', $person->slug) }}" class="block group transition-transform hover:scale-[1.02]">
                <div class="flex items-center space-x-4 p-4 bg-slate-800 rounded-xl mb-4 border border-slate-700 group-hover:border-indigo-500 transition-colors shadow-lg">
                    
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg border-2 border-slate-600 overflow-hidden">
                        @if($person->avatar)
                            <img src="{{ asset('storage/' . $person->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-white font-black text-xl tracking-tighter uppercase">
                                {{ substr($person->name, 0, 1) }}
                            </span>
                        @endif
                    </div>

                    <div class="flex-grow">
                        <div class="flex items-center justify-between">
                            <h3 class="text-white font-bold text-lg group-hover:text-indigo-300 transition-colors">{{ $person->name }}</h3>
                            <span class="text-xs font-mono text-indigo-400 bg-indigo-500/10 px-2 py-1 rounded">
                                {{ $person->slug }}
                            </span>
                        </div>
                        <p class="text-slate-400 text-xs italic">
                            🎂 Nacimiento: {{ \Carbon\Carbon::parse($person->birth)->format('d M, Y') }}
                        </p>
                        <p class="text-[10px] text-indigo-500 font-bold uppercase tracking-widest mt-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            Ver Perfil →
                        </p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endsection