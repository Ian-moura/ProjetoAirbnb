<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propriedade extends Model
{
    use HasFactory;

    protected $table = 'propriedades'; // Nome da tabela
    
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'address',
        'zip_code',
        'price_per_night',
        'max_guests',
        'bedrooms',
        'bathrooms',
        'amenities',
        'estado_id', // Adicione esta linha
        'cidade_id', // Adicione esta linha
    ];
    
    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'cidade_id'); // Corrigido
    }
    
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id'); // Corrigido
    }

    // Relacionamentos
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function imagens()
    {
        return $this->hasMany(Imagem::class, 'property_id');
    }

    public function pagamentos()
    {
        return $this->hasMany(Pagamento::class, 'property_id');
    }

    // Adicionando o relacionamento com Reviews
    public function reviews()
    {
        return $this->hasMany(Review::class, 'property_id');
    }
}
