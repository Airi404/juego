@extends('layouts.base')
@section('title', 'PixelNexus AI - Evoluciona')

@section('content')
<div class="relative overflow-hidden pt-12 pb-32">
    <div class="container mx-auto px-6 relative z-10">
        <div class="flex flex-col items-center text-center">
            <span class="text-indigo-500 font-bold tracking-widest uppercase text-sm mb-4">Módulo de Inteligencia Artificial</span>
            <h1 class="text-5xl md:text-7xl font-black mb-6 bg-gradient-to-r from-white to-slate-500 bg-clip-text text-transparent">
                NEXUS <span class="text-indigo-600">CORE AI</span>
            </h1>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="bg-slate-900 rounded-3xl border border-slate-800 shadow-2xl overflow-hidden shadow-indigo-500/10">
                
                <div class="bg-slate-800/50 px-6 py-4 border-b border-slate-700 flex items-center justify-between">
                    <div class="flex space-x-2">
                        <div class="w-3 h-3 rounded-full bg-red-500/20 border border-red-500"></div>
                        <div class="w-3 h-3 rounded-full bg-yellow-500/20 border border-yellow-500"></div>
                        <div class="w-3 h-3 rounded-full bg-green-500/20 border border-green-500"></div>
                    </div>
                    <span class="text-xs font-mono text-slate-500 tracking-widest uppercase">Gemini 1.5 Flash Connected</span>
                </div>

                <div class="p-8">
                    @if(isset($respuesta))
                        <div class="flex flex-col items-end mb-8">
                            <div class="bg-indigo-600 text-white px-6 py-3 rounded-2xl rounded-tr-none max-w-[80%] shadow-lg">
                                <p class="text-sm font-bold opacity-70 mb-1">TÚ</p>
                                <p class="text-lg">{{ $prompt }}</p>
                            </div>
                        </div>

                        <div class="flex flex-col items-start mb-8">
                            <div class="bg-slate-800 border border-indigo-500/30 text-slate-200 px-6 py-4 rounded-2xl rounded-tl-none max-w-[90%] shadow-xl shadow-indigo-500/5">
                                <p class="text-xs font-bold text-indigo-400 mb-2 uppercase tracking-tighter italic">Nexus Core v2.0</p>
                                <div class="text-lg leading-relaxed font-light">
                                    {!! nl2br(e($respuesta)) !!}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-10">
                            <div class="w-20 h-20 mx-auto bg-indigo-600/20 rounded-full flex items-center justify-center mb-4 border border-indigo-500/30 animate-pulse">
                                <i class="fas fa-robot text-indigo-500 text-3xl"></i>
                            </div>
                            <p class="text-slate-400 italic">"Esperando entrada de datos... ¿En qué puedo ayudarte hoy, Gamer?"</p>
                        </div>
                    @endif

                    <form action="{{ route('chatbot.send') }}" method="POST" class="mt-8">
                        @csrf
                        <div class="relative group">
                            <input type="text" name="prompt" autocomplete="off"
                                class="w-full bg-slate-950 border border-slate-700 text-white px-6 py-5 rounded-2xl focus:outline-none focus:border-indigo-500 transition-all placeholder:text-slate-600 shadow-inner"
                                placeholder="Escribe un comando o pregunta a la IA..." required>
                            
                            <button type="submit" 
                                class="absolute right-3 top-3 bottom-3 bg-indigo-600 hover:bg-indigo-500 px-6 rounded-xl font-bold text-sm transition-all flex items-center group-hover:shadow-lg shadow-indigo-500/20">
                                ENVIAR →
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-8 flex justify-center space-x-6 text-slate-600 text-[10px] uppercase font-bold tracking-widest">
                <span class="flex items-center"><span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span> System Ready</span>
                <span>Encrypted Connection</span>
                <span>AI Core: Active</span>
            </div>
        </div>
    </div>
</div>
@endsection