@extends('layouts.base')
@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-3xl font-black text-white uppercase mb-8 italic">Terminal de Juegos</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-slate-900 p-6 rounded-2xl border border-fuchsia-500/30">
            <h2 class="text-white font-bold mb-4">INICIAR NUEVA PARTIDA</h2>
            <form action="{{ route('game.store') }}" method="POST">
                @csrf
                <input type="text" name="room_name" placeholder="Nombre de la sala..." class="w-full bg-slate-950 p-2 text-white rounded mb-4">
                <button class="bg-fuchsia-600 w-full py-2 rounded font-bold uppercase">Crear Sala</button>
            </form>
        </div>

        <div class="bg-slate-900/50 p-6 rounded-2xl border border-slate-800">
            <h2 class="text-indigo-400 font-bold mb-4">SALAS ACTIVAS</h2>
            @foreach($games as $game)
                <div class="flex justify-between items-center mb-2 p-3 bg-slate-800 rounded-lg">
                    <span class="text-white font-mono">{{ $game->room_name }}</span>
                    <a href="{{ route('game.show', $game->id) }}" class="text-xs bg-indigo-500 px-3 py-1 rounded">ENTRAR</a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection