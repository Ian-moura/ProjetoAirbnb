<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estado;
class EstadoController extends Controller
{
    public function index()
    {
        // Busca todos os estados ativos
        $estados = Estado::get();

        // Array que armazenará os estados com suas cidades
        $estadosComCidades = [];

        $cidadeController = new CidadeController;
        // Para cada estado, busca 5 cidades e adiciona ao array
        foreach ($estados as $estado) {
            // Busca as 5 primeiras cidades para o estado atual
            $cidades = $cidadeController->getCidadesPorEstado($estado->id);

            // Adiciona ao array associando o estado com suas cidades
            $estadosComCidades[] = [
                'estado' => $estado,  // Estado atual
                'cidades' => $cidades // Cidades desse estado
            ];
        }

        // Retorna os estados com suas respectivas cidades para a view
        return view('estado.index', compact('estadosComCidades'));
    }

    public function IncluirEstado(Request $request){
        $est_nome = $request->input("est_nome");
        $est_descricao = $request->input("est_descricao");
        
        $nova = new Estado;
        $nova->est_nome = $est_nome;
        $nova->est_descricao = $est_descricao;
        $nova->save();

        return redirect("/estado");
    }

    public function ExcluirEstado($id){
        $est = Estado::where("id",$id)->first();
        $est->est_ativo = 0;
        $est->save();
    }

    public function EditarEstado($id){
        $estado = Estado::where("id",$id)->first();
        return view("estado.alterar",compact("estado"));
    }

    public function ExecutaAlteracao(Request $request){
        $dado_nome = $request->input("est_nome");
        $dado_descricao = $request->input("est_descricao");
        $id = $request->input("id");
        $estado = Estado::where("id",$id)->first();
        $estado->est_nome = $dado_nome;
        $estado->est_descricao = $dado_descricao;
        $estado->save();
        return redirect("/estado");
    }
}
