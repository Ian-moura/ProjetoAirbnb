<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cidade;

class CidadeController extends Controller
{
    public function getCidadesPorEstado($idEstado)
    {
        // Busca as 5 cidades com base no idEstado
        $cidades = Cidade::where('idEstado', $idEstado)
                         ->take(5)
                         ->get();

        return $cidades; // Retorna a coleção de cidades
    }

}
