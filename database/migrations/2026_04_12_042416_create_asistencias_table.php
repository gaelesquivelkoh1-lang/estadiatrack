<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estancia_id')->constrained('estancias');
            $table->foreignId('alumno_id')->constrained('alumnos');
            $table->date('fecha');
            $table->enum('estatus', ['asistencia', 'falta', 'justificada', 'retardo']);
            $table->text('nota')->nullable();
            $table->foreignId('registrado_por')->nullable()->constrained('admins');
            $table->timestamps();

            $table->unique(['estancia_id', 'alumno_id', 'fecha']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};