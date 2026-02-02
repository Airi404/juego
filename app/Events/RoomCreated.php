<?php

namespace App\Events;

use App\Models\Game;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoomCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $game;

   public function __construct(Game $game)
    {
        // Forzamos a que el objeto olvide cualquier relación previa y cargue solo lo necesario
        $this->game = $game->withoutRelations()->load('user');
    }

    public function broadcastOn(): array
    {
        return [new Channel('lobby')]; // Canal público para todos los que están en la lista
    }

    public function broadcastAs(): string
    {
        return 'RoomCreated';
    }
}