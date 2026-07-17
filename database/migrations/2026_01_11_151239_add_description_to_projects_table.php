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
        // La columna puede existir ya (la migración de creación la incluye):
        // guardamos para que la migración sea idempotente en instalaciones nuevas.
        if (! Schema::hasColumn('projects', 'descripcion')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->text('descripcion')->nullable()->after('titulo');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            //
        });
    }
};
