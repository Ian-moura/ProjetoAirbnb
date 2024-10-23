<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    public function EditarUser($id){
        $user = User::where("id",$id)->first();
        return view("estado.alterarUser",compact("user"));
    }

    public function ExecutaAlteracao(Request $request){
        $dado_name = $request->input("name");
        $dado_email = $request->input("email");
        $id = $request->input("id");
        $user = User::where("id",$id)->first();
        $user->name = $dado_name;
        $user->email = $dado_email;
        $user->save();
        return redirect()->route('user_upd',['id' => $id]);
    }
}
