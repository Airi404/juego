<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MoveMade;
use App\Events\GameDeleted;
use App\Events\RoomCreated;

class GameController extends Controller
{
    public function index() {
        $games = Game::with(['user', 'player2'])->latest()->get(); 
        return view('lista_juegos', compact('games'));
    }

    public function store(Request $request) {
        $request->validate([
            'room_name' => 'required|unique:games,room_name|max:50',
            'password' => 'nullable|min:3',
        ]);

        $game = Game::create([
            'room_name' => $request->room_name,
            'user_id' => Auth::id(),
            'password' => $request->password,
            'board' => ' , , , , , , , , ',
            'active_player' => 'X',
            'state' => 'active'
        ]);

        broadcast(new RoomCreated($game))->toOthers();
        return redirect()->route('game.show', $game->id); 
    }

    public function show(Request $request, $id) {
        $game = Game::with(['user', 'player2'])->findOrFail($id);
        $user = Auth::user();

        // 1. Si ya eres parte, entras directo
        if ($user->id === $game->user_id || $user->id === $game->player2_id) {
            return view('juego', compact('game'));
        }

        // 2. Validación de contraseña
        if (!empty($game->password)) {
            if ($request->password !== $game->password) {
                return view('juego_password', [
                    'game' => $game,
                    'error' => $request->has('password') ? 'Código de acceso denegado' : null
                ]);
            }
        }

        // 3. Unirse a la sala
        if (!$game->player2_id && $game->user_id !== $user->id && !$request->has('spectate')) {
            $game->update(['player2_id' => $user->id]);
            $game->refresh(); 
            
            // Avisar a la sala y al lobby
            broadcast(new MoveMade($game))->toOthers();
            broadcast(new RoomCreated($game))->toOthers();
        }

        return view('juego', compact('game'));
    }

    public function play(Request $request, $id) 
    {
        $game = Game::findOrFail($id);
        $user = Auth::user();

        $isPlayer1 = $user->id === $game->user_id;
        $isPlayer2 = $user->id === $game->player2_id;
        
        if (!$isPlayer1 && !$isPlayer2) return back();
        
        $mySymbol = $isPlayer1 ? 'X' : 'O';
        if ($game->active_player !== $mySymbol || $game->state !== 'active') return back();

        $board = explode(',', $game->board);
        $pos = $request->input('square');

        if (isset($board[$pos]) && trim($board[$pos]) === '') {
            $board[$pos] = $game->active_player;
            $game->board = implode(',', $board);

            $winner = $this->checkWinner($board);
            
            if ($winner) {
                $game->state = 'won_' . $winner;
            } elseif (!collect($board)->contains(fn($cell) => trim($cell) === '')) {
                $game->state = 'tie';
            } else {
                $game->active_player = ($game->active_player === 'X') ? 'O' : 'X';
            }

            $game->save();
            broadcast(new MoveMade($game))->toOthers();
        }

        return back();
    }

    public function leave($id) {
        $game = Game::findOrFail($id);
        $userId = Auth::id();

        if ($userId == $game->user_id) {
            broadcast(new GameDeleted($game->id))->toOthers();
            $game->delete();
            return redirect()->route('game.list');
        } 

        if ($game->player2_id && (int)$userId === (int)$game->player2_id) {
            $game->update([
                'player2_id' => null,
                'state' => 'active',
                'board' => ' , , , , , , , , ',
                'active_player' => 'X'
            ]);

            $game->refresh();
            // Esto elimina cualquier rastro del jugador 2 en el JSON del broadcast
            $game->unsetRelation('player2');

            broadcast(new MoveMade($game))->toOthers();
            broadcast(new RoomCreated($game))->toOthers();
        }

        return redirect()->route('game.list');
    }

    public function destroy($id) {
        $game = Game::findOrFail($id);
        if (Auth::id() === $game->user_id) {
            broadcast(new GameDeleted($id))->toOthers();
            // Notificamos al lobby que la sala ya no existe
            broadcast(new RoomCreated($game))->toOthers(); 
            $game->delete();
        }
        return redirect()->route('game.list');
    }

    private function checkWinner($board) {
        $lines = [[0,1,2],[3,4,5],[6,7,8],[0,3,6],[1,4,7],[2,5,8],[0,4,8],[2,4,6]];
        foreach ($lines as $line) {
            [$a, $b, $c] = $line;
            if (trim($board[$a]) !== '' && trim($board[$a]) === trim($board[$b]) && trim($board[$a]) === trim($board[$c])) {
                return trim($board[$a]);
            }
        }
        return null;
    }
}