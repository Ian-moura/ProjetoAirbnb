<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::middleware('auth')->group(function () {
    Route::get('/',[EstadoController::class,'index'])->name('index');
    Route::get('/estado',[EstadoController::class,'index'])->name('index'); 
    Route::post('/estado',[EstadoController::class,'IncluirEstado']);
});



Route::get('/registrar', function(){
    return view('admin_layout.register');
})->name('registrar');
Route::get('/login', function(){
    return view('admin_layout.login');
})->name('login');


Route::post('/registrar', [AuthController::class, 'register']);


Route::post('/login', [AuthController::class, 'login']);

Route::get('/estado/exc/{id}',[EstadoController::class,'ExcluirEstado'])->name("estado_ex");

Route::get('/estado/upd/{id}',[EstadoController::class,'EditarEstado'])->name("estado_upd");

Route::post('/estado/upd',[EstadoController::class,'ExecutaAlteracao']);

Route::get('/user/exc/{id}',[UserController::class,'ExcluirUser'])->name("user_ex");

Route::get('/user/upd/{id}',[UserController::class,'EditarUser'])->name("user_upd");

Route::post('/user/upd',[UserController::class,'ExecutaAlteracao']);