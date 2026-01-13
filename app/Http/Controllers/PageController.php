<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person; 
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PageController extends Controller
{
    public function homepage() {
        // Equivale a "FROM Person SELECT *" [cite: 43, 45]
        $persons = Person::all();
        // Pasamos los argumentos a la vista en un diccionario [cite: 47, 51]
        return view('home', ['persons' => $persons]);
    }

    public function register(Request $request) {
    // Validamos que el email sea único en la tabla 'users'
   $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'birth' => 'required|date|before:today', // <--- RESTRICTCIÓN: No permite fechas futuras
    ]);

    // Si la validación falla, Laravel vuelve atrás automáticamente con los errores.
    // Si pasa, continúa con la creación:
    
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

   Person::create([
        'user_id' => $user->id,
        'name' => $request->name,
        'birth' => $request->birth,
        // Añadimos el ID del usuario al slug para que sea único siempre
        'slug' => \Illuminate\Support\Str::slug($request->name) . '-' . $user->id,
    ]);
    Auth::login($user);
    $request->session()->regenerate();

    return redirect()->route('home');
}

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas']);
    }

   public function logout(Request $request) {
        Auth::logout();

        // Invalidamos la sesión por seguridad
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirigimos al home (que ya sabemos que existe y tiene nombre)
        return redirect()->route('home');
    }
    public function showPerson($slug)
    {
        // Buscamos a la persona y cargamos su usuario asociado para sacar el email
        $person = \App\Models\Person::where('slug', $slug)->firstOrFail();
        
        // Buscamos al usuario dueño de esta persona para obtener su correo
        $userAccount = \App\Models\User::find($person->user_id);

        return view('persona', [
            'person' => $person,
            'email' => $userAccount ? $userAccount->email : 'Sin correo',
        ]);
    }
    public function storeProduct(Request $request) {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
        ]);

        // Creamos el producto pero ASOCIANDO el ID del usuario logueado
        \App\Models\Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'user_id' => auth()->id(), // Requisito clave: asociar al usuario [cite: 225, 296]
        ]);

        return redirect()->back();
    }
}