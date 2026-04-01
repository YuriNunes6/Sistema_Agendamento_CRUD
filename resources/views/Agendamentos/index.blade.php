@extends('layouts.app')

@section('title', 'Agendamentos')

@section('content')
<div class="p-8">
    <div class="flex justify-between mb-6">
        <h1 class="text-2xl font-semibold">Agendamentos</h1>
        <a href="{{ route('agendamentos.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg">Novo Agendamento</a>
    </div>

    <table class="w-full text-left border rounded-lg overflow-hidden">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-2">Cliente</th>
                <th class="px-4 py-2">Serviço</th>
                <th class="px-4 py-2">Data</th>
                <th class="px-4 py-2">Horário</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2 text-right">Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($agendamentos as $a)
            <tr class="border-t">
                <td class="px-4 py-2">{{ $a->cliente }}</td>
                <td class="px-4 py-2">{{ $a->servico }}</td>
                <td class="px-4 py-2">{{ $a->data }}</td>
                <td class="px-4 py-2">{{ $a->horario }}</td>
                <td class="px-4 py-2 capitalize">{{ $a->status }}</td>
                <td class="px-4 py-2 text-right">
                    <a href="{{ route('agendamentos.edit', $a->id) }}" class="text-indigo-600 mr-2">Editar</a>
                    <form action="{{ route('agendamentos.destroy', $a->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600">Excluir</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-4 text-gray-400">Nenhum agendamento encontrado.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection