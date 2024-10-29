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
        Schema::create('comodidades', function (Blueprint $table) {
            $table->id(); // Cria a coluna id
            $table->string('nome', 100); // Nome da comodidade
            $table->text('descricao')->nullable(); // Descrição opcional da comodidade
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
        Schema::dropIfExists('comodidades'); // Remove a tabela se existir
    }
};
