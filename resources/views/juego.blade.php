@extends('layouts.base')

@section('content')
<div class="max-w-md mx-auto text-center mt-10">
    
    <h1 class="text-3xl font-black text-white italic uppercase tracking-tighter">
        Sala: <span class="text-indigo-500">{{ $game->room_name }}</span>
    </h1>

    <div class="mt-2 mb-6 flex flex-col items-center gap-1">
        <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">
            Creador de la sala: <span class="text-indigo-400">{{ $game->user->name }}</span>
        </p>
        
        {{-- Si el usuario no es el creador, mostramos que es espectador --}}
        @if(Auth::id() !== $game->user_id)
            <span class="px-3 py-1 bg-amber-500/20 border border-amber-500/50 text-amber-500 text-[10px] font-black uppercase rounded-full tracking-widest animate-pulse mt-2">
                Modo Espectador
            </span>
        @endif
    </div>
    
    <div class="inline-grid grid-cols-3 gap-1 bg-slate-700 p-1 rounded-lg shadow-2xl border border-slate-600">
        @php $board = explode(',', $game->board); @endphp
        @foreach($board as $index => $value)
            @php $val = trim($value); @endphp
            
            @if(Auth::id() === $game->user_id)
                {{-- VISTA DUEÑO: Puede pulsar para jugar --}}
                <form action="{{ route('game.play', $game->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="square" value="{{ $index }}">
                    <button 
                        {{ $game->state !== 'active' || $val !== '' ? 'disabled' : '' }}
                        class="w-20 h-20 bg-slate-900 flex items-center justify-center text-4xl font-black transition-all hover:bg-slate-800 disabled:cursor-default
                        {{ $val === 'X' ? 'text-red-600' : '' }}
                        {{ $val === 'O' ? 'text-blue-600' : '' }}">
                        {{ $val }}
                    </button>
                </form>
            @else
                {{-- VISTA ESPECTADOR: Solo ve el estado, no hay botones --}}
                <div class="w-20 h-20 bg-slate-900 flex items-center justify-center text-4xl font-black
                    {{ $val === 'X' ? 'text-red-600' : '' }}
                    {{ $val === 'O' ? 'text-blue-600' : '' }}">
                    {{ $val }}
                </div>
            @endif
        @endforeach
    </div>

    <div class="mt-8">
        {{-- Mensajes de victoria/empate --}}
        @if($game->state !== 'active')
            <div class="mb-6 p-4 bg-indigo-900/50 border border-indigo-500 rounded-xl">
                <h2 class="text-white font-black uppercase text-lg italic">
                    @if($game->state === 'tie') ¡Empate! 
                    @elseif($game->state === 'won_X') <span class="text-red-600">¡GANADOR X!</span> 
                    @else <span class="text-blue-600">¡GANADOR O!</span> @endif
                </h2>
            </div>
        @else
            <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest mb-6">
                Turno de: 
                <span class="{{ $game->active_player === 'X' ? 'text-red-600' : 'text-blue-600' }} text-sm">
                    {{ $game->active_player }}
                </span>
            </p>
        @endif

        <div class="flex flex-col gap-4 items-center">
            {{-- BOTÓN SALIR: Siempre visible para todos, no borra la sala --}}
            <a href="{{ route('game.list') }}" class="text-slate-400 hover:text-white text-[10px] font-bold uppercase tracking-widest transition-all underline decoration-indigo-500/50">
                Salir de la sala
            </a>

            {{-- BOTÓN ELIMINAR: Solo para el dueño y solo si terminó (Requisito 6) --}}
            @if(Auth::id() === $game->user_id && $game->state !== 'active')
                <form action="{{ route('game.destroy', $game->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-500 text-white px-6 py-2 rounded-full font-black uppercase text-[10px] tracking-widest transition-all shadow-lg shadow-red-900/40">
                        Cerrar Sala Definitivamente
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection