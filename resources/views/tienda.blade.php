@extends('layouts.base')

@section('title', 'Marketplace - PixelProject')

@section('content')
<div class="max-w-4xl mx-auto mt-6 p-4">
    
    <div class="flex items-center justify-between mb-10 border-b border-indigo-500/30 pb-4">
        <div>
            <h1 class="text-5xl font-black text-white italic tracking-tighter uppercase">
                Global <span class="text-indigo-500">Market</span>
            </h1>
            <p class="text-slate-500 text-xs font-mono mt-1">SISTEMA DE compra DE ITEMS ACTIVO_</p>
        </div>
        <div class="text-right">
            <span class="text-[10px] text-indigo-400 font-black block">TOTAL_ITEMS</span>
            <span class="text-2xl font-black text-white">{{ count($products) }}</span>
        </div>
    </div>

    @auth
        <div class="relative mb-16">
            <div class="absolute -inset-0.5 bg-gradient-to-r from-indigo-500 to-fuchsia-600 rounded-3xl blur opacity-20 z-0"></div>
            
            <form action="{{ route('tienda.store') }}" method="POST" class="relative z-10 bg-slate-900 border border-indigo-500/30 p-8 rounded-3xl shadow-2xl">
                @csrf
                <h3 class="text-indigo-400 text-xs font-black uppercase tracking-widest mb-6 flex items-center">
                    <span class="w-2 h-2 bg-indigo-500 rounded-full mr-2 animate-pulse"></span>
                    Registrar nuevo item en la tienda
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="name" placeholder="Nombre del Item" required 
                        class="bg-slate-950 border border-slate-700 rounded-xl p-3 text-white focus:border-indigo-500 outline-none transition-colors">
                    
                    <input type="number" step="0.01" name="price" placeholder="Precio" required 
                        class="bg-slate-950 border border-slate-700 rounded-xl p-3 text-white focus:border-indigo-500 outline-none transition-colors">
                    
                    <textarea name="description" placeholder="Descripción técnica del objeto..." required 
                        class="md:col-span-2 bg-slate-950 border border-slate-700 rounded-xl p-3 text-white focus:border-indigo-500 outline-none h-24 transition-colors"></textarea>
                </div>

                <button type="submit" class="w-full mt-6 bg-indigo-600 hover:bg-indigo-500 text-white font-black py-3 rounded-xl uppercase tracking-widest transition-all transform active:scale-95 shadow-lg shadow-indigo-500/20">
                    Subir al Marketplace
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($products as $product)
                <div class="bg-slate-800/40 border border-slate-700 p-6 rounded-2xl hover:border-fuchsia-500/50 transition-all group shadow-xl">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-xl font-black text-white uppercase italic group-hover:text-fuchsia-400 transition-colors">
                            {{ $product->name }}
                        </h3>
                        <span class="text-indigo-400 font-mono font-bold">{{ number_format($product->price, 2) }} €</span>
                    </div>
                    <p class="text-slate-400 text-sm mb-4 line-clamp-2">{{ $product->description }}</p>
                    <div class="border-t border-slate-700 pt-4 flex justify-between items-center text-[10px] font-bold uppercase tracking-widest">
                        <span class="text-slate-500">Vendedor: <span class="text-white">{{ $product->user->name }}</span></span>
                        <span class="text-fuchsia-500">ID #{{ $product->id }}</span>
                    </div>
                </div>
            @endforeach
        </div>

    @else
        <div class="text-center py-20 bg-slate-900/50 rounded-3xl border border-dashed border-slate-700">
            <svg class="w-16 h-16 text-slate-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
            <h2 class="text-xl font-bold text-slate-500 uppercase tracking-widest">Contenido Restringido</h2>
            <p class="text-slate-600 text-sm mt-2">
                Debes <a href="/login" class="text-indigo-500 hover:underline font-bold">iniciar sesión</a> para ver el mercado y publicar items.
            </p>
        </div>
    @endauth
</div>
@endsection