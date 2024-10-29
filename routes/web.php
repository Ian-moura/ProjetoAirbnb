<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PropriedadeController;
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\ReviewController;

// Rotas de autenticação
Route::get('/login', function() {
    return view('admin_layout.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);
Route::get('/registrar', function() {
    return view('admin_layout.register');
})->name('registrar');
Route::post('/registrar', [AuthController::class, 'register']);

// Rotas autenticadas
Route::middleware('auth')->group(function () {
    // Rotas de estado
    Route::get('/estado/exc/{id}', [EstadoController::class, 'ExcluirEstado'])->name("estado_ex");
    Route::get('/estado/upd/{id}', [EstadoController::class, 'EditarEstado'])->name("estado_upd");
    Route::post('/estado/upd', [EstadoController::class, 'ExecutaAlteracao']);
    Route::post('/estado', [EstadoController::class, 'IncluirEstado']);
    Route::get('/estado', [EstadoController::class, 'index'])->name('index'); 

    // Rotas de usuário
    Route::get('/user/exc/{id}', [UserController::class, 'ExcluirUser'])->name("user_ex");
    Route::get('/user/upd/{id}', [UserController::class, 'EditarUser'])->name("user_upd");
    Route::post('/user/upd', [UserController::class, 'ExecutaAlteracao']);

    // Rotas de propriedades
    Route::get('/criarPropriedade', [PropriedadeController::class, 'create'])->name('criarPropriedade');
    Route::post('/propriedades/criar', [PropriedadeController::class, 'store'])->name('propriedades.store');
    Route::get('/propriedades/upd/{id}', [PropriedadeController::class, 'edit'])->name('propriedades.edit');
    Route::put('/propriedades/upd/{id}', [PropriedadeController::class, 'update'])->name('propriedades.update');
    Route::get('/propriedades/del/{id}', [PropriedadeController::class, 'destroy'])->name('propriedades.delete');


    // Rotas de reviews
    Route::post('/reviews', [ReviewController::class, 'store'])->name("review.store");

    // Rotas de pagamento
    Route::post('/propriedades', [MercadoPagoController::class, 'checkout'])->name('pagamento');
    Route::post('/payment/update/{id}', [MercadoPagoController::class, 'updatePaymentStatus'])->name('payment.update');
    Route::post('/mercadopago/notification', [MercadoPagoController::class, 'notification']);

    // Logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout'); 
});

// Rotas públicas
Route::get('/propriedades/search', [PropriedadeController::class, 'search'])->name('propriedades.search');
Route::get('/propriedades/mostra/{id}', [PropriedadeController::class, 'mostra'])->name('propriedades.show');
Route::get('/propriedades/{id}', [PropriedadeController::class, 'propriedadesUsuario'])->name('propriedades');

Route::get('/', [EstadoController::class, 'index']);
