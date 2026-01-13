@extends('layouts.base')

@section('title', 'Editar Mi Perfil - PixelProject')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-slate-800 rounded-3xl border border-slate-700 shadow-2xl p-8 transition-all hover:border-indigo-500/50">
        
        <div class="flex flex-col items-center text-center mb-8">
            <span class="text-indigo-500 font-bold tracking-widest uppercase text-sm mb-2">Configuración</span>
            <h1 class="text-4xl font-black text-white">MI <span class="text-indigo-600">PERFIL</span></h1>
        </div>

        <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            <div class="flex flex-col items-center">
                <div class="w-40 h-40 rounded-full border-4 border-indigo-600 shadow-indigo-500/40 shadow-2xl overflow-hidden bg-slate-900 flex items-center justify-center mb-4">
                    
                    @php
                        // Buscamos los datos de la "Persona" asociada a este usuario
                        $personaLogueada = \App\Models\Person::where('user_id', Auth::id())->first();
                    @endphp

                    @if($personaLogueada && $personaLogueada->avatar)
                        <img src="{{ asset('storage/' . $personaLogueada->avatar) }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-white text-6xl font-black tracking-tighter uppercase">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </span>
                    @endif
                </div>
                <span class="text-xs font-mono text-indigo-400 bg-indigo-500/10 px-2 py-1 rounded">
                    {{ Auth::user()->name }}
                </span>
                <p class="text-slate-400 text-sm italic">Vista previa del avatar actual</p>
            </div>

            <div class="bg-slate-900/50 p-6 rounded-2xl border border-slate-700">
                <label class="block text-indigo-400 font-bold mb-4 uppercase text-xs tracking-wider">Subir Nueva Imagen</label>
                <input type="file" name="avatar" accept="image/*" required
                    class="block w-full text-sm text-slate-400
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-bold
                    file:bg-indigo-600 file:text-white
                    hover:file:bg-indigo-500 transition-all">
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex-grow bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-4 rounded-2xl transition-all transform hover:scale-[1.02]">
                    Guardar y volver a Home
                </button>
                <a href="{{ route('home') }}" class="bg-slate-700 hover:bg-slate-600 text-white font-bold py-4 px-8 rounded-2xl transition-all">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection