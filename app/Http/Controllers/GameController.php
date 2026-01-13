<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    /**
     * Muestra la lista de todas las salas y el formulario para crear una (Task 10.1)
     */
    public function index() {
        $games = Game::all(); 
        return view('lista_juegos', compact('games'));
    }

    /**
     * Crea una nueva sala en la base de datos (Task 10.1)
     */
    public function store(Request $request) {
        $request->validate([
            'room_name' => 'required|unique:games,room_name|max:50',
        ]);

        $game = Game::create([
            'room_name' => $request->room_name,
            'user_id' => Auth::id(), // El usuario que crea la sala es el dueño
            'board' => ' , , , , , , , , ', // Inicializamos con 9 espacios vacíos
            'active_player' => 'X',
            'state' => 'active'
        ]);

        return redirect()->route('game.show', $game->id);
    }

    /**
     * Muestra el tablero de un juego específico por su ID (Task 10.2)
     */
    public function show($id) {
        $game = Game::findOrFail($id);
        return view('juego', compact('game'));
    }

    /**
     * Procesa el movimiento de una ficha (Task 10.4 y 10.5)
     */
    public function play(Request $request, $id) {
        $game = Game::findOrFail($id);
        
        // REQUISITO TASK 10.5: Solo el dueño puede realizar movimientos
        if (Auth::id() !== $game->user_id) {
            return back()->with('error', 'Solo el dueño de la sala puede jugar.');
        }

        $board = explode(',', $game->board);
        $pos = $request->input('square'); // Índice de la casilla (0-8)

        // Validamos que el juego esté activo y la casilla esté vacía
        if ($game->state === 'active' && trim($board[$pos]) === '') {
            $board[$pos] = $game->active_player;
            
            // Comprobamos si hay un ganador o empate
            if ($this->checkWinner($board)) {
                $game->state = 'won_' . $game->active_player;
            } elseif (!in_array(' ', $board)) {
                $game->state = 'tie';
            } else {
                // Cambiar el turno al siguiente jugador
                $game->active_player = ($game->active_player === 'X') ? 'O' : 'X';
            }

            $game->board = implode(',', $board);
            $game->save();
        }

        return back();
    }

    /**
     * Lógica para comprobar combinaciones ganadoras
     */
    private function checkWinner($b) {
        $lines = [
            [0,1,2], [3,4,5], [6,7,8], // Filas
            [0,3,6], [1,4,7], [2,5,8], // Columnas
            [0,4,8], [2,4,6]           // Diagonales
        ];
        foreach ($lines as $line) {
            if (trim($b[$line[0]]) !== '' && 
                $b[$line[0]] === $b[$line[1]] && 
                $b[$line[0]] === $b[$line[2]]) {
                return true;
            }
        }
        return false;
    }

    /**
     * Elimina la sala de la base de datos (Task 10.6)
     */
    public function destroy($id) {
        $game = Game::findOrFail($id);
        
        // Solo el dueño puede cerrar su propia sala
        if (Auth::id() === $game->user_id) {
            $game->delete();
        }
        
        return redirect()->route('game.list');
    }
}