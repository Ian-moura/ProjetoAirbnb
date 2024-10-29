<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    use HasFactory;

    // Define os campos que podem ser preenchidos em massa
    protected $fillable = [
        'property_id',
        'user_id',
        'amount',
        'status',
        'transaction_date',
    ];

    // Define a tabela associada ao modelo (opcional, caso a tabela siga a convenção)
    protected $table = 'pagamentos';

    // Se você estiver usando timestamps, não precisa definir a propriedade $timestamps
    // Caso contrário, se você não estiver usando timestamps, defina como false
    public $timestamps = true;

    // Relacionamento com a tabela de reservas
    public function reserva()
    {
        return $this->belongsTo(Propriedade::class, 'property_id');
    }

    // Relacionamento com a tabela de usuários
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
