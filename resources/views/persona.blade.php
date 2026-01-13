@extends('layouts.base')

@section('title', 'Perfil de ' . $person->name)

@section('content')
<div class="max-w-lg mx-auto mt-6 p-2">
    <div class="relative group">
        <div class="absolute -inset-1 bg-gradient-to-r from-cyan-400 via-fuchsia-500 to-indigo-600 rounded-3xl blur-md opacity-40 group-hover:opacity-75 transition duration-500"></div>
        
        <div class="relative bg-slate-900 rounded-3xl p-6 text-center shadow-2xl border border-white/10">
            
            <div class="flex flex-col items-center mb-4">
                <div class="relative">
                    <div class="absolute inset-0 rounded-full bg-cyan-500 blur-md opacity-20"></div>
                    
                    <div class="relative w-32 h-32 rounded-full border-4 border-cyan-400 shadow-[0_0_15px_rgba(34,211,238,0.5)] overflow-hidden bg-slate-950 flex items-center justify-center">
                        @if($person->avatar)
                            <img src="{{ asset('storage/' . $person->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-white text-5xl font-black italic drop-shadow-[0_0_8px_rgba(255,255,255,0.4)]">
                                {{ substr($person->name, 0, 1) }}
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="mt-3 inline-flex items-center px-3 py-1 rounded-full border border-fuchsia-500/30 bg-fuchsia-500/10">
                    <span class="text-fuchsia-400 font-mono text-[10px] tracking-[0.2em] uppercase">ID:{{ $person->slug }}</span>
                </div>
            </div>

            <h1 class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-white via-cyan-200 to-fuchsia-300 mb-1 uppercase italic">
                {{ $person->name }}
            </h1>
            <p class="text-slate-400 font-medium text-xs tracking-wider mb-6">
                {{ $email }}
            </p>
            
            <div class="grid grid-cols-2 gap-3 text-left">
                <div class="bg-slate-950/80 p-3 rounded-xl border-t-2 border-cyan-500 shadow-inner">
                    <p class="text-cyan-500 text-[9px] uppercase font-black tracking-widest mb-1">Birth_Date</p>
                    <p class="text-lg text-white font-black italic">
                        {{ \Carbon\Carbon::parse($person->birth)->format('d/m') }}
                    </p>
                </div>
                
                <div class="bg-slate-950/80 p-3 rounded-xl border-t-2 border-fuchsia-500 shadow-inner">
                    <p class="text-fuchsia-500 text-[9px] uppercase font-black tracking-widest mb-1">Join_Date</p>
                    <p class="text-lg text-white font-black italic uppercase">
                        {{ \Carbon\Carbon::parse($person->created_at)->format('M y') }}
                    </p>
                </div>
            </div>

            <div class="mt-8">
                <a href="{{ route('home') }}" 
                   class="group/btn relative inline-flex items-center px-6 py-3 font-black text-[11px] text-white uppercase tracking-[0.2em] overflow-hidden rounded-xl border border-white/20 transition-all hover:border-cyan-400">
                    <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-cyan-600/20 to-fuchsia-600/20 opacity-0 group-hover/btn:opacity-100 transition-opacity"></span>
                    <span class="relative flex items-center">
                        <span class="mr-2">←</span> Return_Home
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection