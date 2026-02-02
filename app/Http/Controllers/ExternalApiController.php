<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ExternalApiController extends Controller
{
    public function index(Request $request)
    {
        // Limpiamos el texto: sin espacios y en minúsculas
        $search = trim(strtolower($request->input('pokemon', '')));

        // 1. Obtenemos una lista grande (500 pokemons) para tener con qué comparar
        // Esto se hace en el backend para cumplir con la TASK 13
        $listResponse = Http::withoutVerifying()->get("https://pokeapi.co/api/v2/pokemon?limit=500");
        $pokemonList = [];
        if ($listResponse->successful()) {
            $pokemonList = collect($listResponse->json()['results'])->pluck('name')->toArray();
        }

        // 2. Si no hay búsqueda, mostramos la página limpia con la lista
        if (empty($search)) {
            return view('external_api.index', ['pokemonList' => $pokemonList, 'apiData' => null]);
        }

        // 3. Intentamos buscar el pokemon exacto en la API
        $response = Http::withoutVerifying()->get("https://pokeapi.co/api/v2/pokemon/{$search}");

        if ($response->successful()) {
            return view('external_api.index', [
                'apiData' => $response->json(),
                'pokemonList' => $pokemonList
            ]);
        }

        // 4. LÓGICA "QUIZÁS QUISISTE DECIR"
        // Si la API falla (ej: pusiste "picachu"), buscamos el más cercano en nuestra lista
        $suggestion = $this->getClosestMatch($search, $pokemonList);

        return view('external_api.index', [
            'apiData' => null,
            'suggestion' => $suggestion,
            'search' => $search,
            'pokemonList' => $pokemonList
        ]);
    }

    private function getClosestMatch($input, $list)
    {
        $closest = null;
        $shortest = -1;

        foreach ($list as $name) {
            // Levenshtein calcula cuántos cambios separan $input de $name
            $lev = levenshtein($input, $name);

            // Si hay un parecido razonable (distancia pequeña)
            if ($lev <= $shortest || $shortest < 0) {
                $closest = $name;
                $shortest = $lev;
            }
        }

        // Si la palabra es demasiado distinta (más de 3 letras de error), no sugerimos
        return ($shortest <= 3) ? $closest : null;
    }
}