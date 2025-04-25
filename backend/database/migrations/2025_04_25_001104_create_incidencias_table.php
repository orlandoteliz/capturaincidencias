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
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_id')->constrained();
            $table->foreignId('concepto_id')->constrained();
            $table->decimal('cantidad', 10, 2)->nullable();
            $table->date('fecha');
            $table->string('tipo_incidencia')->nullable();
            $table->string('periodo')->nullable();
            $table->time('hora_entrada')->nullable();
            $table->time('hora_salida')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('estado')->default('pendiente');
            $table->string('last_modified_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidencias');
    }
};
