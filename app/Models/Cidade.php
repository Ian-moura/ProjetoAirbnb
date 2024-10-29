<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    use HasFactory;

    protected $table = 'cidade';

    // Se você tem uma chave primária diferente do padrão (id), especifique-a
    protected $primaryKey = 'id';

    // Se a tabela não tem timestamps, defina como false
    public $timestamps = true;

    // Defina as propriedades que podem ser atribuídas em massa
    protected $fillable = [
        'cidade_nome', // Nome da cidade
        'idEstado', // ID do estado relacionado
    ];

    // Relacionamento com o modelo Estado
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'idEstado');
    }

    // Relacionamento com o modelo Property (caso uma cidade tenha várias propriedades)
    public function propriedades()
    {
        return $this->hasMany(Property::class, 'city');
    }
}
