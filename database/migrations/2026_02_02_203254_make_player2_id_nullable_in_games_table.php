<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table) {
            // Importante: nullable() permite el hueco, change() aplica el cambio
            $table->foreignId('player2_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            // Esto revierte el cambio si fuera necesario
            $table->unsignedBigInteger('player2_id')->nullable(false)->change();
        });
    }
};
