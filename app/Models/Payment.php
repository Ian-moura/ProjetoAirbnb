<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Payment {
    private $user_id = NULL;
    private $property_id = NULL;
    public $pagamento_id = NULL;

    public function __construct($user_id = NULL, $property_id = NULL) {
        $this->user_id = $user_id;
        $this->property_id  = $property_id;
    }

    // Método para obter detalhes de um pagamento específico
    public function getPayment() {
        $query = DB::table('pagamentos')->where('id', $this->pagamento_id)->first();

        return $query ?: false;
    }

    // Método para adicionar um pagamento
    public function addPayment($valor) {
        $id = DB::table('pagamentos')->insertGetId([
            'amount' => $valor,
            'user_id' => $this->user_id,
            'property_id' => $this->property_id,
            'status' => 'pending',
            'transaction_date' => now()
        ]);

        return $id ?: false;
    }

    // Método para definir o status do pagamento
    public function setStatusPayment($status) {
        $updated = DB::table('pagamentos')
            ->where('id', $this->pagamento_id)
            ->update(['status' => $status]);

        return $updated ? true : false;
    }
}
