<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up() {
    Schema::create('games', function (Blueprint $table) {
        $table->id();
        $table->string('room_name')->unique();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // El dueño (Task 10.1)
        $table->string('board')->default(' , , , , , , , , '); // 9 espacios vacíos
        $table->string('active_player')->default('X');
        $table->string('state')->default('active'); // active, won_X, won_O, tie
        $table->foreignId('player2_id')->nullable()->constrained('users');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
