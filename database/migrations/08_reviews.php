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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id(); // Cria a coluna id
            $table->foreignId('property_id')->constrained('propriedades')->onDelete('cascade'); // Chave estrangeira para propriedades
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Chave estrangeira para users
            $table->integer('rating')->unsigned(); // Avaliação (0-5 ou 0-10)
            $table->text('comment')->nullable(); // Comentário da avaliação
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
        Schema::dropIfExists('reviews'); // Remove a tabela se existir
    }
};
