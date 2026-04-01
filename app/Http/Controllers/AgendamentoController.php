<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendamentoController extends Controller {

    public function index(Request $request) {
        $query = Agendamento::query();

        if ($request->filled('data')) {
            $query->where('data', $request->data);
        }

        $agendamentos = $query->orderBy('data', 'asc')->orderBy('horario', 'asc')->get();
        return view('agendamentos.index', compact('agendamentos'));
    }

    public function create() {
        return view('agendamentos.create');
    }

    public function store(Request $request) {
        $request->validate([
            'cliente' => 'required|string|max:255',
            'servico' => 'required|string|max:255',
            'data' => 'required|date',
            'horario' => 'required',
            'observacao' => 'nullable|string',
            'status' => 'required|in:agendado,concluido,cancelado'
        ]);

        Auth::user()->agendamentos()->create($request->all());

        return redirect()->route('agendamentos.index')->with('success', 'Agendamento criado com sucesso!');
    }

    public function edit(Agendamento $agendamento) {
        return view('agendamentos.edit', compact('agendamento'));
    }

    public function update(Request $request, Agendamento $agendamento) {
        $request->validate([
            'cliente' => 'required|string|max:255',
            'servico' => 'required|string|max:255',
            'data' => 'required|date',
            'horario' => 'required',
            'observacao' => 'nullable|string',
            'status' => 'required|in:agendado,concluido,cancelado'
        ]);

        $agendamento->update($request->all());
        return redirect()->route('agendamentos.index')->with('success', 'Agendamento atualizado com sucesso!');
    }

    public function destroy(Agendamento $agendamento) {
        $agendamento->delete();
        return redirect()->route('agendamentos.index')->with('success', 'Agendamento removido!');
    }
}