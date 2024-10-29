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
        Schema::create('imagens_propriedades', function (Blueprint $table) {
            $table->id(); // Cria a coluna id
            $table->foreignId('property_id')->constrained('propriedades')->onDelete('cascade'); // Chave estrangeira para propriedades
            $table->string('image_path'); // Caminho da imagem
            $table->string('alt_text')->nullable(); // Texto alternativo da imagem
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
        Schema::dropIfExists('imagens_propriedades'); // Remove a tabela se existir
    }
};
