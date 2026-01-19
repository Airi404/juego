<?php

namespace App\Events;

use App\Models\Game;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MoveMade implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
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