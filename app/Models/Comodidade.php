<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comodidade extends Model
{
    use HasFactory;

    protected $table = 'comodidades'; // Nome da tabela, use plural para seguir convenções

    // Se a tabela não tem timestamps, defina como false
    public $timestamps = true;

    // Defina as propriedades que podem ser atribuídas em massa
    protected $fillable = [
        'nome', // Nome da comodidade
        'descricao', // Descrição da comodidade (opcional)
    ];

    // Relacionamento com o modelo Property
    public function propriedades()
    {
        return $this->belongsToMany(Property::class, 'comodidade_property', 'comodidade_id', 'property_id');
    }
}
