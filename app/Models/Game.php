<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'room_name', 
        'user_id', 
        'board', 
        'active_player', 
        'state'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}