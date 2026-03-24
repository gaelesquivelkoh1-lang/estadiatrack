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
    Schema::create('bitacoras', function (Blueprint $table) {
        $table->id();
        $table->foreignId('estancia_id')->constrained()->onDelete('cascade');
        $table->date('fecha');
        $table->integer('horas');
        $table->text('descripcion');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacoras');
    }
};
