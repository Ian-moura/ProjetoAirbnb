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
        Schema::create('propriedades', function (Blueprint $table) {
            $table->id(); // Cria a coluna id
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Chave estrangeira para users
            $table->foreignId('estado_id')->constrained('estado')->onDelete('cascade'); // Chave estrangeira para estados
            $table->foreignId('cidade_id')->constrained('cidade')->onDelete('cascade'); // Chave estrangeira para cidades
            $table->string('name', 150); // Nome da propriedade
            $table->text('description'); // Descrição da propriedade
            $table->string('address'); // Endereço da propriedade
            $table->string('zip_code'); // Código postal
            $table->decimal('price_per_night', 10, 2); // Preço por noite
            $table->integer('max_guests'); // Máximo de hóspedes
            $table->integer('bedrooms')->nullable(); // Número de quartos
            $table->integer('bathrooms')->nullable(); // Número de banheiros
            $table->json('amenities')->nullable(); // Amenidades (armazenadas em formato JSON)
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
        Schema::dropIfExists('propriedades'); // Remove a tabela se existir
    }
};
