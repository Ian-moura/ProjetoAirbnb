<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comodidade_property', function (Blueprint $table) {
            $table->id(); // Cria a coluna id
            $table->foreignId('comodidade_id')->constrained('comodidades')->onDelete('cascade'); // Chave estrangeira para comodidades
            $table->foreignId('property_id')->constrained('propriedades')->onDelete('cascade'); // Chave estrangeira para propriedades
            $table->timestamps(); // Cria as colunas created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comodidade_property'); // Remove a tabela se existir
    }
};
