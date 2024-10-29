<?php

namespace App\Http\Controllers;

use App\Models\Review; // Certifique-se de ter o modelo Review
use App\Models\Propriedade; // Certifique-se de ter o modelo Propriedade
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Método para armazenar uma nova avaliação
    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:propriedades,id',
            'rating' => 'required|integer|min:1|max:5', // Supondo que a avaliação seja de 1 a 5
            'comment' => 'nullable|string|max:255',
        ]);

        $review = new Review();
        $review->property_id = $request->property_id;
        $review->user_id = Auth::id(); // Assume que o usuário está autenticado
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();

        return redirect()->back()->with('success', 'Avaliação adicionada com sucesso!');
    }

    // Método para listar avaliações de uma propriedade
    public function index($propertyId)
    {
        $propriedade = Propriedade::with('reviews')->findOrFail($propertyId);

        return view('propriedades.show', compact('propriedade')); // Exibe a propriedade com suas avaliações
    }

    // Método para excluir uma avaliação (opcional)
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        
        // Adicione verificações para garantir que o usuário pode excluir a avaliação
        if ($review->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Você não pode excluir esta avaliação.');
        }

        $review->delete();

        return redirect()->back()->with('success', 'Avaliação excluída com sucesso!');
    }
}
