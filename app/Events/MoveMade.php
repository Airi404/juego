<?php

namespace App\Events;

use App\Models\Game;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MoveMade implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $game;

   public function __construct(Game $game)
    {
        // refresh() asegura que traemos los datos frescos de la DB (el null)
        // withoutRelations() evita enviar datos "fantasma" de relaciones cargadas antes
        $this->game = $game->refresh()->withoutRelations();
    }

    public function broadcastOn(): array
    {
        return [new Channel('game.' . $this->game->id)];
    }

    public function broadcastAs(): string
    {
        return 'MoveMade';
    }
}