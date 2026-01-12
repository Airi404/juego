<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void {
    Schema::create('people', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
        $table->string('name', 50); // Requisito max_length=50
        $table->date('birth');      // Requisito DateField
        $table->string('slug');     // Requisito SlugField
        $table->timestamps();
    });
}

    public function down(): void {
        Schema::dropIfExists('people');
    }
};