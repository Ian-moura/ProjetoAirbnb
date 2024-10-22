<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function EditarUser($id){
        $user = User::where("id",$id)->first();
        return view("user.alterar",compact("user"));
    }

    public function ExecutaAlteracao(Request $request){
        $dado_name = $request->input("name");
        $dado_email = $request->input("email");
        $id = $request->input("id");
        $user = User::where("id",$id)->first();
        $user->est_nome = $dado_name;
        $user->est_descricao = $dado_email;
        $user->save();
        return redirect()->route();
    }
}
