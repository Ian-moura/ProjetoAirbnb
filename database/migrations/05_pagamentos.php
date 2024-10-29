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
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->id(); // Cria a coluna id
            $table->foreignId('property_id')->constrained('propriedades')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Chave estrangeira para users
            $table->decimal('amount', 10, 2); // Montante do pagamento
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending'); // Status do pagamento
            $table->timestamp('transaction_date')->useCurrent(); // Data da transação
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
        Schema::dropIfExists('pagamentos'); // Remove a tabela se existir
    }
};
