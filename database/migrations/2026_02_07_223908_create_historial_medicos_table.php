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
        Schema::create('historial_medicos', function (Blueprint $table) {
            $table->id();

            // Relación con la mascota
            $table->foreignId('mascota_id')->constrained('mascots')->onDelete('cascade');

            // Tipo de evento
            $table->string('tipo'); // Vacuna, Consulta, Desparasitación, Cirugía

            $table->text('descripcion')->nullable(); // Detalles, dosis, síntomas
            $table->decimal('peso', 8, 2)->nullable(); // Peso en ese momento
            $table->date('fecha'); // Cuándo ocurrió
            $table->date('proxima_visita')->nullable(); // Recordatorio (opcional)

            // Archivos adjuntos (Rayos X, PDFs)
            $table->string('archivo')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_medicos');
    }
};
