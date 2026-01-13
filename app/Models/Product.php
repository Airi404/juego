<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'user_id'];
    
    // Relación: Un producto PERTENECE a un usuario (Requisito Task 9)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}