@extends('layouts.app')

@section('title', 'Editar Agendamento')

@section('content')
<div class="p-8 max-w-2xl mx-auto">
    <h1 class="text-2xl font-semibold mb-6">Editar Agendamento</h1>

    <form action="{{ route('agendamentos.update', $agendamento->id) }}" method="POST" class="space-y-4 bg-white p-6 rounded-lg shadow">
        @csrf
        @method('PUT')

        <div>
            <label>Cliente</label>
            <input type="text" name="cliente" value="{{ old('cliente', $agendamento->cliente) }}" required class="w-full p-2 border rounded">
        </div>

        <div>
            <label>Serviço</label>
            <input type="text" name="servico" value="{{ old('servico', $agendamento->servico) }}" required class="w-full p-2 border rounded">
        </div>

        <div class="flex gap-4">
            <div>
                <label>Data</label>
                <input type="date" name="data" value="{{ old('data', $agendamento->data) }}" required class="w-full p-2 border rounded">
            </div>
            <div>
                <label>Horário</label>
                <input type="time" name="horario" value="{{ old('horario', $agendamento->horario) }}" required class="w-full p-2 border rounded">
            </div>
        </div>

        <div>
            <label>Observação</label>
            <textarea name="observacao" class="w-full p-2 border rounded">{{ old('observacao', $agendamento->observacao) }}</textarea>
        </div>

        <div>
            <label>Status</label>
            <select name="status" class="w-full p-2 border rounded">
                <option value="agendado" {{ old('status', $agendamento->status)=='agendado' ? 'selected' : '' }}>Agendado</option>
                <option value="concluido" {{ old('status', $agendamento->status)=='concluido' ? 'selected' : '' }}>Concluído</option>
                <option value="cancelado" {{ old('status', $agendamento->status)=='cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Salvar</button>
    </form>
</div>
@endsection