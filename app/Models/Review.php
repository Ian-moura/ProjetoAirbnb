<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews'; // Nome da tabela

    // Definindo os atributos que podem ser atribuídos em massa
    protected $fillable = [
        'user_id',        // ID do usuário que fez a review
        'property_id',    // ID da propriedade que está sendo avaliada
        'rating',         // Classificação da review (ex: 1 a 5)
        'comment',        // Comentário da review
    ];

    // Definindo os relacionamentos
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id'); // Relacionamento com o usuário
    }

    public function propriedade()
    {
        return $this->belongsTo(Propriedade::class, 'property_id'); // Relacionamento com a propriedade
    }
}
