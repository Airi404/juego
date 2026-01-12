@extends('layouts.base')

@section('content')
<div class="max-w-md mx-auto bg-slate-800 p-8 rounded-2xl border border-indigo-500 shadow-2xl">
    <h2 class="text-2xl font-bold mb-6 text-white text-center">Crea tu cuenta</h2>

    {{-- Bloque de errores de validación --}}
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-500/10 border border-red-500/50 rounded-xl">
            <ul class="text-red-400 text-sm list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/registro" method="POST" class="space-y-4">
        @csrf
        {{-- Conservamos el valor anterior con old() para que el usuario no tenga que escribir todo de nuevo si hay un error --}}
        <input type="text" name="name" value="{{ old('name') }}" placeholder="Tu nombre" class="w-full p-2 bg-slate-700 rounded border border-slate-600 focus:border-indigo-500 outline-none text-white" required>
        
        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="w-full p-2 bg-slate-700 rounded border border-slate-600 focus:border-indigo-500 outline-none text-white" required>
        
        <label class="block text-xs text-slate-400 ml-1 mb-[-10px]">Fecha de nacimiento</label>
        <input type="date" name="birth" value="{{ old('birth') }}" class="w-full p-2 bg-slate-700 rounded border border-slate-600 focus:border-indigo-500 outline-none text-white" required>
        
        <input type="password" name="password" placeholder="Contraseña (mín. 8 caracteres)" class="w-full p-2 bg-slate-700 rounded border border-slate-600 focus:border-indigo-500 outline-none text-white" required>
        
        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 transition-colors py-3 rounded-xl font-bold uppercase tracking-wider text-white shadow-lg shadow-indigo-500/20">
            Registrarse
        </button>
    </form>

    <p class="mt-6 text-center text-slate-400 text-sm">
        ¿Ya tienes cuenta? <a href="/login" class="text-indigo-400 hover:underline">Entra aquí</a>
    </p>
</div>
@endsection