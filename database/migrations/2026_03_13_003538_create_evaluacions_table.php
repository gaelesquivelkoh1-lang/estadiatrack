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
    Schema::create('evaluaciones', function (Blueprint $table) {
        $table->id();
        $table->foreignId('estancia_id')->constrained()->onDelete('cascade');
        $table->integer('calificacion');
        $table->text('comentarios');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluacions');
    }
};
