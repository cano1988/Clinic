<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Cambiar la relación de 'users' a 'patients'
            $table->dropForeign(['patient_id']);  // Eliminar la relación anterior
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade'); // Añadir la nueva relación
        });
    }

public function down()
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Revertir el cambio en caso de rollback
            $table->dropForeign(['patient_id']);
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        });
    }
};
