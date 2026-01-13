<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Person;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('perfil', [
            'user' => Auth::user()
        ]);
    }
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            // Guardamos la imagen físicamente
            $path = $request->file('avatar')->store('avatars', 'public');

            // 1. Actualizamos el avatar en la tabla 'users'
            $user->update(['avatar' => $path]);

            // 2. Actualizamos el avatar en la tabla 'people' usando el user_id
            // Buscamos a la persona cuyo user_id coincida con el ID del usuario logueado
            \App\Models\Person::where('user_id', $user->id)->update(['avatar' => $path]);
        }

        // Tu regla personalizada: redirigir siempre a home
        return redirect()->route('home');
    }
}