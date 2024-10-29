<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Propriedade;
use App\Models\Review;
use App\Models\Imagem;
use App\Models\Estado;
use App\Models\Cidade;
class PropriedadeController extends Controller
{
    public function index()
    {
        // Busca todas as propriedades e conta as avaliações
        $propriedades = Propriedade::withCount('reviews')
        ->selectRaw('(SELECT AVG(rating) FROM reviews WHERE property_id = propriedades.id) as average_rating') 
        ->get();
        
        return view('propriedades.index', compact('propriedades'));
    }

    public function propriedadesUsuario($id)
    {
        // Obtém o ID do usuário do request
        $usuarioId = $id; 


        $propriedades = Propriedade::where('user_id', $usuarioId)
            ->with(['reviews', 'imagens']) 
            ->withCount('reviews')
            ->selectRaw('(SELECT AVG(rating) FROM reviews WHERE property_id = propriedades.id) as average_rating') 
            ->get();
            
        return view('propriedades.index', compact('propriedades'));
    }

    public function mostra($id)
    {
        // Obtém a propriedade pelo ID, incluindo avaliações e imagens
        $propriedade = Propriedade::with(['reviews', 'imagens'])
            ->withCount('reviews')
            ->findOrFail($id); // Alterado para findOrFail
    
        return view('propriedades.mostra', compact('propriedade')); // Compacta um único modelo
    }
    
    
    public function search(Request $request)
    {
        $query = $request->input('query');
    
        // Verifica se a consulta está vazia
        if (empty($query)) {
            return redirect()->route('index')->with('error', 'Por favor, insira um termo de busca.');
        }
    
        // Busca propriedades com base na consulta, incluindo contagem de avaliações e média das notas
        $propriedades = Propriedade::withCount('reviews') // Conta o número de avaliações
            ->select('propriedades.*') // Seleciona todas as colunas da tabela propriedades
            ->selectRaw('(SELECT AVG(rating) FROM reviews WHERE property_id = propriedades.id) as average_rating') 
            ->selectRaw('(SELECT COUNT(rating) FROM reviews WHERE property_id = propriedades.id) as count') // Calcula a média das notas
            ->where('name', 'like', "%{$query}%")
            ->orWhereHas('cidade', function ($query) use ($request) {
                $query->where('cidade_nome', 'like', "%{$request->input('query')}%");
            })
            ->orWhereHas('estado', function ($query) use ($request) {
                $query->where('est_nome', 'like', "%{$request->input('query')}%");
            })
            ->get();
    
        // Retorne a view com as propriedades filtradas
        return view('propriedades.busca', compact('propriedades'));
    }
    
    
    


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'required|string',
            'address' => 'required|string',
            'zip_code' => 'required|string',
            'price_per_night' => 'required|numeric',
            'max_guests' => 'required|integer',
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'amenities' => 'nullable|json',
            'estado_id' => 'required|exists:estado,id',  // Verifique se é 'estados' e não 'estado'
            'cidade_id' => 'required|exists:cidade,id',  // Verifique se é 'cidades' e não 'cidade'
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Criação da propriedade
        $propriedade = Propriedade::create([
            'user_id' => auth()->id(),
            'estado_id' => $request->estado_id,
            'cidade_id' => $request->cidade_id,
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'zip_code' => $request->zip_code,
            'price_per_night' => $request->price_per_night,
            'max_guests' => $request->max_guests,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'amenities' => $request->amenities ? json_decode($request->amenities) : null,
        ]);

        // Salvar imagens, se houver
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Armazena a imagem na pasta 'public/imagens_propriedades'
                $path = $image->store('imagens_propriedades', 'public');
                
                // Cria um registro da imagem no banco de dados
                Imagem::create([
                    'property_id' => $propriedade->id,
                    'image_path' => $path,
                    'alt_text' => $request->name, // Pode ajustar de acordo com a necessidade
                ]);
            }
        }

        return redirect()->route('propriedades', ['id' => auth()->user()->id])->with('success', 'Propriedade criada com sucesso!');
    }



    public function create()
    {
        $estados = Estado::all(); // Altere conforme sua tabela e modelo
        $cidades = Cidade::all(); // Altere conforme sua tabela e modelo

        return view('propriedades.criarPropriedade', compact('estados', 'cidades'));
    }

    public function edit($id)
    {
        // Busca a propriedade para edição
        $propriedade = Propriedade::findOrFail($id);
        $estados = Estado::all(); // Altere conforme sua tabela e modelo
        $cidades = Cidade::all(); // Altere conforme sua tabela e modelo
        return view('propriedades.editar', compact('propriedade','estados', 'cidades'));
    }

    public function update(Request $request, $id)
    {
        // Validação dos dados da propriedade
        $request->validate([
            'name' => 'required|string|max:255',
            'price_per_night' => 'required|numeric',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Atualiza a propriedade
        $propriedade = Propriedade::findOrFail($id);
        $propriedade->name = $request->input('name');
        $propriedade->price_per_night = $request->input('price_per_night');
    
        // Manipulação da nova imagem se fornecida
        if ($request->hasFile('imagem')) {
            $imagem = $request->file('imagem');
            $imagemNome = time() . '.' . $imagem->getClientOriginalExtension();
            $imagem->move(public_path('img'), $imagemNome);
            $propriedade->imagem = $imagemNome;
        }
    
        $propriedade->save();
    
        return redirect()->route('propriedades',['id' => auth()->user()->id] )->with('success', 'Propriedade atualizada com sucesso.');
    }
    

    public function destroy($id)
    {
        // Exclui a propriedade
        $propriedade = Propriedade::findOrFail($id);
        $propriedade->delete();

        return redirect()->route('propriedades',['id' => auth()->user()->id] )->with('success', 'Propriedade excluída com sucesso.');
    }
}
