<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estado;
use App\Models\Propriedade;
use App\Models\Review;


class EstadoController extends Controller
{
    protected $cidadeController;

    public function __construct(CidadeController $cidadeController)
    {
        $this->cidadeController = $cidadeController;
    }

    public function index()
    {
        // Busca estados com suas cidades associadas
        $estadosComCidades = Estado::with('cidades')->get();
        
        // Busca todas as propriedades e conta as avaliações associadas
        $propriedades = Propriedade::withCount('reviews')
        ->selectRaw('(SELECT AVG(rating) FROM reviews WHERE property_id = propriedades.id) as average_rating') 
        ->get();

        // Retorna a view com estados e propriedades
        return view('estado.index', compact('estadosComCidades', 'propriedades'));
    }

    public function incluirEstado(Request $request)
    {
        $validatedData = $request->validate([
            'est_nome' => 'required|string|max:255',
            'est_descricao' => 'nullable|string',
        ]);

        $estado = Estado::create($validatedData);

        return redirect()->route('estado.index')->with('success', 'Estado incluído com sucesso.');
    }

    public function excluirEstado($id)
    {
        $estado = Estado::findOrFail($id);
        $estado->update(['est_ativo' => 0]);

        return redirect()->route('estado.index')->with('success', 'Estado excluído com sucesso.');
    }

    public function editarEstado($id)
    {
        $estado = Estado::findOrFail($id);
        return view("estado.alterar", compact("estado"));
    }

    public function executaAlteracao(Request $request)
    {
        $validatedData = $request->validate([
            'est_nome' => 'required|string|max:255',
            'est_descricao' => 'nullable|string',
            'id' => 'required|exists:estados,id',
        ]);

        $estado = Estado::findOrFail($validatedData['id']);
        $estado->update($validatedData);

        return redirect()->route('estado.index')->with('success', 'Estado alterado com sucesso.');
    }
}
