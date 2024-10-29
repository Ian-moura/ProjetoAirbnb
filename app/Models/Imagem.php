<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagem extends Model
{
    use HasFactory;

    protected $table = 'imagens_propriedades'; // Nome da tabela

    // Defina as propriedades que podem ser atribuídas em massa
    protected $fillable = [
        'property_id', // ID da propriedade associada
        'image_path',         // URL da imagem
        'alt_text',     // Legenda da imagem (opcional)
    ];

    // Defina o relacionamento com o modelo Propriedade
    public function propriedade()
    {
        return $this->belongsTo(Propriedade::class, 'property_id');
    }
}
