<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('error_reports', function (Blueprint $table) {
            $table->id(); // ID autoincremental de Laravel
            $table->integer('code'); // Campo para el código de error 
            $table->text('description'); // Descripción detallada 
            $table->timestamp('date'); // Fecha y hora del error 
            $table->timestamps(); // Crea 'created_at' y 'updated_at' automáticamente
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('error_reports');
    }
};