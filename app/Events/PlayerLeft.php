<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlayerLeft implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $gameId;
    public $playerName;

    public function __construct($gameId, $playerName)
    {
        $this->gameId = $gameId;
        $this->playerName = $playerName;
    }

    public function broadcastOn(): array
    {
        return [new Channel('game.' . $this->gameId)];
    }

    public function broadcastAs(): string
    {
        return 'PlayerLeft';
    }
}