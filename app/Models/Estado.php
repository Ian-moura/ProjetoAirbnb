<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    protected $table = 'estado'; // Nome da tabela

    // Defina as propriedades que podem ser atribuídas em massa
    protected $fillable = [
        'est_nome', // Nome do estado
    ];

    // Defina o relacionamento com o modelo Cidade
    public function cidades()
    {
        return $this->hasMany(Cidade::class, 'idEstado');
    }
}
