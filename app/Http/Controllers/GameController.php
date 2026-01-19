<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MoveMade;
use App\Events\GameDeleted; // Importamos el nuevo evento

class GameController extends Controller
{
    public function index() {
            $games = Game::all(); 
            return view('lista_juegos', compact('games'));
        }

        public function store(Request $request) {
        // 1. Validamos que el nombre sea único antes de intentar insertar
        $request->validate([
            'room_name' => 'required|unique:games,room_name|max:50',
            'password' => 'nullable|min:3',
        ]);

        // 2. UN SOLO bloque de creación (Elimina el que tenías duplicado)
        $game = Game::create([
            'room_name' => $request->room_name,
            'user_id' => Auth::id(),
            'password' => $request->password,
            'board' => ' , , , , , , , , ',
            'active_player' => 'X',
            'state' => 'active'
        ]);

        // 3. TASK 11: Avisar a los demás del tiempo real
        broadcast(new \App\Events\RoomCreated($game))->toOthers();

        // 4. Redirigir al tablero de la nueva sala
        return redirect()->route('game.show', $game->id);
    }
    public function show(Request $request, $id) {
        $game = Game::with(['user', 'player2'])->findOrFail($id);
        $user = Auth::user();

        if ($user->id === $game->user_id || $user->id === $game->player2_id) {
            return view('juego', compact('game'));
        }

        if (!empty($game->password) && $request->password !== $game->password) {
            return view('juego_password', compact('game'))->with('error', $request->has('password') ? 'Clave incorrecta' : null);
        }

        if (!$game->player2_id) {
            $game->update(['player2_id' => $user->id]);
            $game->refresh();
        }

        return view('juego', compact('game'));
    }

    public function play(Request $request, $id) 
    {
        $game = Game::findOrFail($id);
        $user = Auth::user();

        if ($user->id !== $game->user_id && $user->id !== $game->player2_id) {
            return back()->with('error', 'Solo los jugadores pueden mover.');
        }

        $isCreatorTurn = ($user->id === $game->user_id && $game->active_player === 'X');
        $isPlayer2Turn = ($user->id === $game->player2_id && $game->active_player === 'O');

        if (!$isCreatorTurn && !$isPlayer2Turn) {
            return back()->with('error', 'No es tu turno.');
        }

        $board = explode(',', $game->board);
        $pos = $request->input('square');

        if ($game->state === 'active' && trim($board[$pos] ?? '') === '') {
            $board[$pos] = $game->active_player;
            $game->board = implode(',', $board);

            $winner = $this->checkWinner($board);
            if ($winner) {
                $game->state = 'won_' . $winner;
            } elseif (!in_array(' ', $board) && !in_array('', $board) && !in_array('  ', $board)) {
                $game->state = 'tie';
            } else {
                $game->active_player = ($game->active_player === 'X') ? 'O' : 'X';
            }

            $game->save();
            broadcast(new MoveMade($game))->toOthers();
        }

        return back();
    }

    private function checkWinner($board) 
    {
        $lines = [[0,1,2],[3,4,5],[6,7,8],[0,3,6],[1,4,7],[2,5,8],[0,4,8],[2,4,6]];
        foreach ($lines as $line) {
            [$a, $b, $c] = $line;
            if (trim($board[$a]) !== '' && trim($board[$a]) === trim($board[$b]) && trim($board[$a]) === trim($board[$c])) {
                return trim($board[$a]);
            }
        }
        return null;
    }
    // Añadir a GameController.php

   public function leave($id) {
        $game = Game::findOrFail($id);
        $user = Auth::user();

        // Logica para el DUEÑO
        if ($user->id == $game->user_id) {
            broadcast(new \App\Events\GameDeleted($id))->toOthers();
            $game->delete();
        } 
        // Logica para el SEGUNDO JUGADOR
        elseif ($user->id == $game->player2_id) {
            $game->update([
                'player2_id' => null,
                'board' => ' , , , , , , , , ',
                'state' => 'active',
                'active_player' => 'X'
            ]);
            // Avisamos al dueño para que se le limpie el tablero
            broadcast(new \App\Events\PlayerLeft($id, $user->name))->toOthers();
        }

        // Tu instrucción: Siempre a home
        return redirect()->route('/');
    }

    // MÉTODO DESTROY ÚNICO Y MEJORADO
    public function destroy($id) {
        $game = Game::findOrFail($id);
        
        if (Auth::id() === $game->user_id) {
            // Avisar al otro jugador antes de borrar para que lo redirija el JS
            broadcast(new GameDeleted($id))->toOthers();
            $game->delete();
        }
        
        // Redirigir siempre a home como solicitaste
        return redirect('/');
    }
}