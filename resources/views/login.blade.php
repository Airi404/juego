@extends('layouts.base')

@section('title', 'Entrar - PixelProject')

@section('content')
<div class="flex items-center justify-center min-h-[70vh]">
    <div class="w-full max-w-md bg-slate-800 p-8 rounded-3xl border border-indigo-500/30 shadow-2xl">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-black text-white">BIENVENIDO</h2>
            <p class="text-slate-400 text-sm mt-2">Introduce tus credenciales para acceder</p>
        </div>

        {{-- Errores de validación --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-500/20 border border-red-500/50 rounded-lg text-red-400 text-sm">
                Usuario o contraseña incorrectos.
            </div>
        @endif

        <form action="/login" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-xs font-bold text-indigo-400 uppercase tracking-widest mb-2 ml-1">Email</label>
                <input type="email" name="email" 
                    class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white focus:outline-none focus:border-indigo-500 transition"
                    placeholder="ejemplo@pixel.com" required>
            </div>

            <div>
                <label class="block text-xs font-bold text-indigo-400 uppercase tracking-widest mb-2 ml-1">Contraseña</label>
                <input type="password" name="password" 
                    class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white focus:outline-none focus:border-indigo-500 transition"
                    placeholder="••••••••" required>
            </div>

            <div class="flex items-center justify-between text-xs text-slate-400 px-1">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="remember" class="mr-2 accent-indigo-500"> Recordarme
                </label>
                <a href="#" class="hover:text-indigo-400">¿Olvidaste la clave?</a>
            </div>

            <button type="submit" 
                class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 rounded-xl shadow-lg shadow-indigo-500/20 transition-all transform active:scale-95 uppercase tracking-wider">
                Entrar
            </button>
        </form>

        <div class="mt-8 text-center border-t border-slate-700 pt-6">
            <p class="text-slate-400 text-sm">
                ¿No tienes cuenta? 
                <a href="/registro" class="text-indigo-400 font-bold hover:underline ml-1">Regístrate gratis</a>
            </p>
        </div>
    </div>
</div>
@endsection