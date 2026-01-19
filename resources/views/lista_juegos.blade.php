@extends('layouts.base')

@section('content')
<div class="max-w-6xl mx-auto p-6 mt-10">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-black text-white uppercase italic tracking-tighter">
            Game <span class="text-fuchsia-500">Center</span>
        </h1>
        <p class="text-slate-500 text-xs font-bold uppercase tracking-[0.3em]">Selecciona una sala o crea la tuya</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1">
            <div class="bg-slate-900/80 backdrop-blur-xl p-8 rounded-3xl border border-fuchsia-500/30 shadow-[0_0_40px_-15px_rgba(217,70,239,0.3)]">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-2 h-8 bg-fuchsia-600 rounded-full"></div>
                    <h2 class="text-white font-black uppercase italic text-xl">Nueva Partida</h2>
                </div>

                <form action="{{ route('game.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="text-[10px] font-black text-fuchsia-400 uppercase ml-2 mb-1 block">Nombre de la Arena</label>
                        <input type="text" name="room_name" placeholder="Ej: Duelo Mortal" required 
                            class="w-full bg-slate-950 border-2 border-slate-800 rounded-2xl px-4 py-3 text-white outline-none focus:border-fuchsia-500 transition-all placeholder:text-slate-700">
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-fuchsia-400 uppercase ml-2 mb-1 block">Contraseña de acceso</label>
                        <input type="password" name="password" placeholder="••••••••" 
                            class="w-full bg-slate-950 border-2 border-slate-800 rounded-2xl px-4 py-3 text-white outline-none focus:border-fuchsia-500 transition-all placeholder:text-slate-700">
                    </div>

                    <button class="group relative w-full bg-fuchsia-600 hover:bg-fuchsia-500 text-white font-black py-4 rounded-2xl transition-all transform hover:-translate-y-1 active:scale-95 shadow-lg shadow-fuchsia-900/20 overflow-hidden">
                        <span class="relative z-10 uppercase tracking-widest italic">Inicializar Protocolo</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]"></div>
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-slate-900/40 backdrop-blur-md p-8 rounded-3xl border border-slate-800">
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-8 bg-indigo-600 rounded-full"></div>
                        <h2 class="text-white font-black uppercase italic text-xl">Salas Activas</h2>
                    </div>
                    <span class="bg-indigo-500/10 text-indigo-400 text-[10px] font-black px-3 py-1 rounded-full border border-indigo-500/20 uppercase">
                        {{ $games->count() }} Online
                    </span>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    @forelse($games as $game)
                        <div class="group bg-slate-800/50 hover:bg-slate-800 p-5 rounded-2xl flex justify-between items-center border border-slate-700/50 hover:border-indigo-500/50 transition-all">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-slate-900 rounded-xl flex items-center justify-center text-xl shadow-inner">
                                    {{ $game->password ? '🔐' : '🎮' }}
                                </div>
                                <div>
                                    <h3 class="text-white font-bold uppercase tracking-tight">{{ $game->room_name }}</h3>
                                    <p class="text-slate-500 text-[10px] font-bold uppercase">Creador: <span class="text-slate-300">{{ $game->user->name }}</span></p>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                @if(!$game->player2_id)
                                    <a href="{{ route('game.show', $game->id) }}" 
                                        class="bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-tighter transition-all shadow-lg shadow-indigo-900/20">
                                        Entrar a Jugar
                                    </a>
                                @endif
                                <a href="{{ route('game.show', $game->id) }}" 
                                    class="bg-slate-700 hover:bg-slate-600 text-slate-300 px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-tighter transition-all">
                                    Espectador
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-20 border-2 border-dashed border-slate-800 rounded-3xl">
                            <p class="text-slate-600 font-black uppercase italic tracking-widest text-sm">No hay arenas disponibles</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes shimmer {
        100% { transform: translateX(100%); }
    }
</style>
<script type="module">
    document.addEventListener('DOMContentLoaded', () => {
        if (window.Echo) {
            window.Echo.channel('lobby')
                .listen('.RoomCreated', (e) => { // ¡EL PUNTO (.) ES OBLIGATORIO!
                    console.log('Nueva sala recibida:', e);
                    window.location.reload(); 
                });
        }
    });
</script>
@endsection