<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table) {
            // Añadimos la contraseña después del nombre
            $table->string('password')->nullable()->after('room_name');
            
            // Añadimos el segundo jugador después del creador
            $table->foreignId('player2_id')->nullable()->after('user_id')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn(['password', 'player2_id']);
        });
    }
};