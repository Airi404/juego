<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Game extends Model
{
    protected $fillable = [
        'room_name', 
        'user_id', 
        'player2_id', 
        'board', 
        'active_player', 
        'state', 
        'password'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function player2(): BelongsTo {
        return $this->belongsTo(User::class, 'player2_id');
    }
}