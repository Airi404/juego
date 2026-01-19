@extends('layouts.base')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4">
    <div class="max-w-md w-full text-center bg-slate-900/80 backdrop-blur-xl p-10 rounded-3xl border-2 border-indigo-500/50 shadow-[0_0_50px_-12px_rgba(99,102,241,0.5)]">
        
        <div class="relative w-20 h-20 mx-auto mb-6">
            <div class="absolute inset-0 bg-indigo-500 rounded-full animate-ping opacity-20"></div>
            <div class="relative bg-slate-800 border-2 border-indigo-500 w-20 h-20 rounded-full flex items-center justify-center shadow-[0_0_20px_rgba(99,102,241,0.4)]">
                <span class="text-3xl">🔐</span>
            </div>
        </div>

        <h2 class="text-white font-black uppercase tracking-tighter text-3xl mb-2 italic">
            Área <span class="text-indigo-500">Restringida</span>
        </h2>
        <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-8">
            Sala: <span class="text-white">{{ $game->room_name }}</span>
        </p>

        <form action="{{ route('game.show', $game->id) }}" method="GET" class="space-y-4">
            <div class="relative group">
                <input type="password" name="password" placeholder="••••••••" required autofocus
                    class="w-full bg-slate-950 border-2 border-slate-800 rounded-2xl px-6 py-4 text-white text-center tracking-[1em] outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all placeholder:tracking-normal placeholder:text-slate-700">
                <div class="absolute inset-0 rounded-2xl pointer-events-none group-focus-within:border-indigo-500/50"></div>
            </div>

            @if(isset($error))
                <div class="bg-red-500/10 border border-red-500/50 py-2 rounded-lg">
                    <p class="text-red-500 text-[10px] font-black uppercase italic tracking-widest">
                        ⚠️ {{ $error }}
                    </p>
                </div>
            @endif

            <button type="submit" 
                class="group relative w-full bg-indigo-600 hover:bg-indigo-500 text-white font-black py-4 rounded-2xl transition-all transform hover:-translate-y-1 active:scale-95 shadow-[0_10px_20px_-10px_rgba(79,70,229,0.6)] overflow-hidden">
                <span class="relative z-10 uppercase tracking-widest italic">Desbloquear Acceso</span>
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]"></div>
            </button>
        </form>

        <div class="mt-8">
            <a href="{{ route('game.list') }}" 
                class="text-slate-500 hover:text-indigo-400 text-[10px] font-black uppercase tracking-widest transition-colors flex items-center justify-center gap-2 group">
                <span class="group-hover:-translate-x-1 transition-transform">←</span> 
                Abortar Misión
            </a>
        </div>
    </div>
</div>

<style>
    @keyframes shimmer {
        100% { transform: translateX(100%); }
    }
</style>
@endsection