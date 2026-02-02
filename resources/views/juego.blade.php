@extends('layouts.base')

@section('content')
<div class="max-w-md mx-auto text-center mt-10 px-4">
    <h1 class="text-white font-black uppercase italic text-2xl tracking-tighter">
        Sala: <span class="text-indigo-500">{{ $game->room_name }}</span>
    </h1>

    <div class="flex justify-between items-center bg-slate-800 p-4 rounded-2xl mt-4">
        <div class="text-center">
            <p class="text-fuchsia-500 font-black">X</p>
            <p class="text-white text-xs">{{ $game->user->name }}</p>
        </div>
        <div class="text-slate-600 font-black italic">VS</div>
        <div class="text-center">
            <p class="text-cyan-500 font-black">O</p>
            @if($game->player2)
                <p class="text-white text-xs">{{ $game->player2->name }}</p>
            @else
                <p class="text-slate-500 text-xs animate-pulse italic">Esperando rival...</p>
            @endif
        </div>
    </div>

    <div class="mt-6 mb-8">
        @if($game->state === 'active')
            <div class="bg-slate-900/50 border border-indigo-500/30 py-4 rounded-2xl backdrop-blur-sm">
                <p class="text-white font-black text-xl italic uppercase">
                    Turno de {{ $game->active_player }}: 
                    <span class="text-indigo-500">
                        {{ $game->active_player === 'X' ? $game->user->name : ($game->player2 ? $game->player2->name : 'Esperando...') }}
                    </span>
                </p>
            </div>
        @else
            <div class="bg-slate-800 p-6 rounded-3xl border-2 border-indigo-500">
                <h2 class="text-white font-black text-xl uppercase italic">{{ str_replace('_', ' ', $game->state) }}</h2>
            </div>
        @endif
    </div>

    @php $isPlayer = (Auth::id() === $game->user_id || Auth::id() === $game->player2_id); @endphp
    <div class="inline-grid grid-cols-3 gap-3 bg-slate-800 p-3 rounded-3xl border border-slate-700 shadow-2xl">
        @php $board = explode(',', $game->board); @endphp
        @foreach($board as $index => $value)
            @php $val = trim($value); @endphp
            @if($isPlayer)
                <form action="{{ route('game.play', $game->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="square" value="{{ $index }}">
                    <button {{ $game->state !== 'active' || $val !== '' ? 'disabled' : '' }}
                        class="w-24 h-24 bg-slate-950 rounded-2xl flex items-center justify-center text-5xl font-black transition-all
                        {{ $val === 'X' ? 'text-red-500' : 'text-blue-400' }}
                        {{ $game->state === 'active' && $val === '' ? 'hover:bg-slate-900 cursor-pointer' : 'cursor-default' }}">
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

    <div class="mt-10 flex flex-col gap-4 items-center w-full max-w-xs mx-auto">
        @if(Auth::id() == $game->user_id)
            <form action="{{ route('game.destroy', $game->id) }}" method="POST" class="w-full">
                @csrf @method('DELETE')
                <button type="submit" class="w-full bg-red-600 text-white font-black py-4 rounded-2xl uppercase italic active:scale-95">
                    Eliminar Sala
                </button>
            </form>
        @else
            <a href="{{ route('game.leave', $game->id) }}" onclick="window.isLeaving = true;"
               class="w-full text-center bg-slate-700 text-white px-6 py-4 rounded-2xl text-xs font-black uppercase active:scale-95">
                Abandonar Sala
            </a>
        @endif
    </div>
</div>

<script type="module">
    document.addEventListener('DOMContentLoaded', () => {
        if (window.Echo) {
            window.isLeaving = false;
            const channel = window.Echo.channel('game.{{ $game->id }}');

            const refreshBoard = () => {
                if(window.isLeaving) return;
                fetch(window.location.href)
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newContent = doc.querySelector('.max-w-md');
                        if(newContent) document.querySelector('.max-w-md').innerHTML = newContent.innerHTML;
                    });
            };

            channel.listen('.MoveMade', (e) => { refreshBoard(); });
            channel.listen('.GameDeleted', (e) => { window.location.href = '/'; });
        }
    });
</script>
@endsection