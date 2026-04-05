<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('convenios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumno_id')->constrained('alumnos');

            // Datos de la empresa
            $table->string('empresa_nombre');
            $table->string('empresa_calle');
            $table->string('empresa_colonia');
            $table->string('empresa_cp', 10);
            $table->string('empresa_municipio');
            $table->string('empresa_rfc', 20);
            $table->string('empresa_representante');
            $table->string('empresa_giro');

            // Contacto de la empresa (Cláusula Octava)
            $table->string('contacto_nombre');
            $table->string('contacto_telefono', 20);
            $table->string('contacto_email');

            // Estado del convenio
            $table->enum('estatus', ['pendiente', 'firmado', 'rechazado'])->default('pendiente');
            $table->date('fecha_firma')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('convenios');
    }
};