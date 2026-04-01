<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgendamentoController;
use App\Models\Agendamento;

/*
|--------------------------------------------------------------------------
| ROTAS DE AUTENTICAÇÃO
|--------------------------------------------------------------------------
*/

// Cadastro
Route::get('/register', [AuthController::class, 'showCadastro'])->name('register');
Route::post('/register', [AuthController::class, 'cadastroSubmit'])->name('register.submit');

// Login
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/', [AuthController::class, 'login'])->name('login.submit');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ROTAS PROTEGIDAS (usuário logado)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |----------------------------------------------------------------------
    | DASHBOARD
    |----------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
        // Total de agendamentos
        $totalAgendamentos = Agendamento::count();

        // Últimos 5 agendamentos
        $ultimosAgendamentos = Agendamento::orderBy('data', 'desc')->take(5)->get();

        return view('user.dashboard', compact(
            'totalAgendamentos',
            'ultimosAgendamentos'
        ));
    })->name('dashboard');

    /*
    |----------------------------------------------------------------------
    | PERFIL DO USUÁRIO
    |----------------------------------------------------------------------
    */
    Route::prefix('profile')->group(function () {
        Route::get('/', [UserController::class, 'profile'])->name('user.profile');
        Route::get('/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/update', [UserController::class, 'update'])->name('user.update');
    });

    /*
    |----------------------------------------------------------------------
    | CRUD DE AGENDAMENTOS
    |----------------------------------------------------------------------
    */
    Route::resource('agendamentos', AgendamentoController::class)->parameters([
        'agendamentos' => 'agendamento'
    ]);
});