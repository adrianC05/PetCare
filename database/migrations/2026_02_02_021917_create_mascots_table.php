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
        Schema::create('mascots', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('breed')->nullable(); // Raza
            $table->decimal('weight', 8, 2); // 8 dígitos, 2 decimales

            // AGREGA ESTAS DOS LÍNEAS QUE FALTAN:
            $table->date('birthdate')->nullable();
            $table->string('species')->nullable();

            // Foto
            $table->string('photo_path')->nullable();

            // Tu relación con el usuario
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mascots');
    }
};
