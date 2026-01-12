<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Person extends Model {
    // Añadimos 'user_id' para ligarlo al usuario
    protected $fillable = ['name', 'birth', 'slug', 'user_id'];

    // Relación con el modelo User (Equivalente a ForeignKey en Django)
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    // Identificador descriptivo para el panel de administración
    public function __toString() {
        return $this->name;
    }
}