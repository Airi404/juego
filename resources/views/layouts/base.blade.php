<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi App Modular')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-900 text-white min-h-screen">
   <nav class="bg-slate-800 p-4 border-b border-indigo-500 flex justify-between">
        <div class="font-bold text-indigo-400"><a href="/">PixelProject</a></div>
        
        <div class="space-x-4 text-sm flex items-center">
            <a href="/" class="group flex items-center space-x-1 text-slate-300 hover:text-indigo-400 transition-colors"><span class="text-xs uppercase font-bold tracking-tighter">Home</span></a>
        @auth
            <div class="flex items-center space-x-6">
                <a href="/tienda" class="group flex items-center space-x-1 text-slate-300 hover:text-indigo-400 transition-colors">
                    <span class="text-xs uppercase font-bold tracking-tighter">Tienda</span>
                </a>
                
                <a href="{{ route('game.list') }}" class="group flex items-center space-x-1 text-slate-300 hover:text-indigo-400 transition-colors">
                    <span class="text-xs uppercase font-bold tracking-tighter">Juego</span>
                </a>

                <div class="h-4 w-px bg-slate-700"></div>
                <div class="flex flex-col items-end mr-2">
                    <span class="text-[10px] text-indigo-400 font-black uppercase tracking-widest">Online</span>
                    <span class="text-xs font-bold text-white">{{ Auth::user()->name }}</span>
                </div>
                <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 group bg-slate-900/50 py-1 pl-1 pr-3 rounded-full border border-slate-700 hover:border-indigo-500/50 transition-all">
                    <div class="w-8 h-8 rounded-full overflow-hidden border border-indigo-500 shadow-sm shadow-indigo-500/20">
                        
                        @php
                            $navPerson = \App\Models\Person::where('user_id', Auth::id())->first();
                        @endphp
                        
                        @if($navPerson && $navPerson->avatar)
                            <img src="{{ asset('storage/' . $navPerson->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-indigo-600 flex items-center justify-center text-[10px] font-black">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <span class="text-xs font-bold text-slate-300 group-hover:text-white transition-colors">Mi Perfil</span>
                </a>

                <form action="/logout" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-[10px] uppercase font-black text-red-500/70 hover:text-red-400 transition-colors tracking-widest">
                        Salir
                    </button>
                </form>
            </div>
        @else
            <div class="flex items-center space-x-3">
                <a href="/login" class="text-sm font-bold bg-indigo-600 px-4 py-2 rounded-xl hover:bg-indigo-500 shadow-lg shadow-indigo-900/20 transition-all transform hover:-translate-y-0.5">
                    Entrar
                </a>
                <a href="/registro" class="text-sm font-bold border border-indigo-500/50 px-4 py-2 rounded-xl hover:bg-indigo-500/10 transition-all">
                    Registrarse
                </a>
            </div>
        @endauth
        </div>
    </nav>

    <main class="p-8">
        @yield('content') </main>
</body>
</html>