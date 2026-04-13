<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->string('rol_temp')->default('vinculacion')->after('password');
        });

        DB::table('admins')->update(['rol_temp' => DB::raw('rol')]);

        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('rol');
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->renameColumn('rol_temp', 'rol');
        });

        // Agregar empresa_id para vincular admin de empresa con su empresa
        Schema::table('admins', function (Blueprint $table) {
            $table->foreignId('empresa_id')->nullable()->constrained('empresas')->after('activo');
        });
    }

    public function down(): void {}
};