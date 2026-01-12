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
        <div class="font-bold text-indigo-400">PixelProject</div>
        
        <div class="space-x-4 text-sm flex items-center">
            <a href="/" class="hover:text-white">Inicio</a>

            @auth
                <a href="/tienda" class="hover:text-indigo-500">Tienda</a>
                <a href="/juego" class="hover:text-indigo-500">Juego</a>
                <form action="/logout" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-red-400">Salir</button>
                </form>
            @else
                <a href="/login" class="bg-indigo-600 px-3 py-1 rounded hover:bg-indigo-700">Entrar</a>
                <a href="/registro" class="border border-indigo-500 px-3 py-1 rounded hover:bg-indigo-700">Registrarse</a>
            @endauth
        </div>
    </nav>

    <main class="p-8">
        @yield('content') </main>
</body>
</html>