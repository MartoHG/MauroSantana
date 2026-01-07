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
    Schema::create('projects', function (Blueprint $table) {
        $table->id();
        
        // Datos del proyecto
        $table->string('titulo'); 
        
        // NUEVO: Campo para diferenciar Proyecto de Ordenanza
        $table->enum('tipo', ['Proyecto', 'Ordenanza'])->default('Proyecto'); 

        $table->text('descripcion')->nullable(); 
        $table->date('fecha'); 
        $table->string('categoria'); 
        $table->string('estado')->default('publicado');
        
        // Archivos
        $table->string('pdf_path'); // Ruta del PDF
        $table->string('qr_path')->nullable(); // Ruta del QR

        // NUEVO: Ruta para la imagen de portada (tipo noticia)
        $table->string('imagen_path')->nullable(); 

        // Relación con el usuario (Admin)
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
