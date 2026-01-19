@extends('layouts.base')

@section('content')
<div class="max-w-md mx-auto text-center mt-10 px-4">
    <h1 class="text-white font-black uppercase italic text-2xl tracking-tighter">
        Sala: <span class="text-indigo-500">{{ $game->room_name }}</span>
    </h1>
    
    <div class="mt-6 mb-8">
        @if($game->state === 'active')
            <div class="bg-slate-900/50 border border-indigo-500/30 py-4 rounded-2xl backdrop-blur-sm">
                <p class="text-indigo-400 font-bold uppercase tracking-widest text-[10px] mb-1">Esperando movimiento</p>
                <p class="text-white font-black text-xl italic uppercase">
                    Turno de {{ $game->active_player }}: 
                    <span class="text-indigo-500">
                        {{ $game->active_player === 'X' ? $game->user->name : ($game->player2 ? $game->player2->name : 'Esperando rival...') }}
                    </span>
                </p>
            </div>
        @elseif($game->state === 'won_X')
            <div class="bg-red-600/20 border-2 border-red-500 p-6 rounded-3xl shadow-[0_0_30px_rgba(239,68,68,0.4)] animate-bounce">
                <p class="text-white/60 text-[10px] font-bold uppercase mb-1">¡Partida Finalizada!</p>
                <h2 class="text-red-500 font-black text-2xl uppercase italic tracking-tighter">
                    🏆 VICTORIA PARA X: {{ $game->user->name }}
                </h2>
            </div>
        @elseif($game->state === 'won_O')
            <div class="bg-blue-600/20 border-2 border-blue-500 p-6 rounded-3xl shadow-[0_0_30px_rgba(59,130,246,0.4)] animate-bounce">
                <p class="text-white/60 text-[10px] font-bold uppercase mb-1">¡Partida Finalizada!</p>
                <h2 class="text-blue-500 font-black text-2xl uppercase italic tracking-tighter">
                    🏆 VICTORIA PARA O: {{ $game->player2->name }}
                </h2>
            </div>
        @elseif($game->state === 'tie')
            <div class="bg-slate-800 border-2 border-slate-500 p-6 rounded-3xl">
                <h2 class="text-white font-black text-2xl uppercase italic tracking-tighter">🤝 ¡EMPATE TÉCNICO!</h2>
                <p class="text-slate-400 text-xs font-bold uppercase mt-2">
                    {{ $game->user->name }} vs {{ $game->player2 ? $game->player2->name : '?' }}
                </p>
            </div>
        @endif
    </div>

    @php 
        $isPlayer = (Auth::id() === $game->user_id || Auth::id() === $game->player2_id);
    @endphp

    <div class="inline-grid grid-cols-3 gap-3 bg-slate-800 p-3 rounded-3xl border border-slate-700 shadow-2xl">
        @php $board = explode(',', $game->board); @endphp
        @foreach($board as $index => $value)
            @php $val = trim($value); @endphp
            @if($isPlayer)
                <form action="{{ route('game.play', $game->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="square" value="{{ $index }}">
                    <button {{ $game->state !== 'active' || $val !== '' ? 'disabled' : '' }}
                        class="w-24 h-24 bg-slate-950 rounded-2xl flex items-center justify-center text-5xl font-black transition-all duration-200
                        {{ $val === 'X' ? 'text-red-500 shadow-[inset_0_0_20px_rgba(239,68,68,0.2)]' : 'text-blue-400 shadow-[inset_0_0_20px_rgba(59,130,246,0.2)]' }}
                        {{ $game->state === 'active' && $val === '' ? 'hover:bg-slate-900 hover:scale-95 cursor-pointer border border-slate-800 focus:border-indigo-500' : 'cursor-default' }}">
                        {{ $val }}
                    </button>
                </form>
            @else
                <div class="w-24 h-24 bg-slate-950 rounded-2xl flex items-center justify-center text-5xl font-black {{ $val === 'X' ? 'text-red-500' : 'text-blue-400' }}">
                    {{ $val }}
                </div>
            @endif
        @endforeach
    </div>
    <div class="mt-10 flex flex-col gap-4 items-center">
        
        @if(Auth::id() == $game->user_id || Auth::id() == $game->player2_id)
            <a href="{{ route('game.leave', $game->id) }}" 
            class="bg-slate-700 hover:bg-slate-600 text-white px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-lg active:scale-95">
                Abandonar Partida
            </a>
        @endif

        @if(Auth::id() == $game->user_id && $game->state !== 'active')
            <form action="{{ route('game.destroy', $game->id) }}" method="POST" class="w-full">
                @csrf @method('DELETE')
                <button class="w-full bg-red-600 hover:bg-red-500 text-white font-black py-4 rounded-2xl uppercase italic transition-all shadow-lg shadow-red-900/40">
                    Eliminar Sala Definitivamente
                </button>
            </form>
        @endif
    </div>
</div>

<script type="module">
    document.addEventListener('DOMContentLoaded', () => {
        if (window.Echo) {
            const channel = window.Echo.channel('game.{{ $game->id }}');

            channel.listen('.MoveMade', (e) => {
                window.location.reload(); 
            });

            channel.listen('.GameDeleted', (e) => {
                window.location.href = '/'; 
            });

            channel.listen('.PlayerLeft', (e) => {
                window.location.reload(); 
            });
        }
    });
</script>
@endsection