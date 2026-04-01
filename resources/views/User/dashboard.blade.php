@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-slate-200 hidden md:flex flex-col">
        <div class="p-6">
            <div class="flex items-center gap-2 font-bold text-xl text-indigo-600">
                📅 Sistema de Agendamentos
            </div>
        </div>
        <nav class="flex-1 px-4 space-y-2">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-3 bg-indigo-50 text-indigo-700 rounded-lg font-medium">
                Dashboard
            </a>
            <a href="{{ route('agendamentos.index') }}" class="flex items-center gap-3 p-3 text-slate-600 hover:bg-slate-100 rounded-lg transition">
                Agendamentos
            </a>
        </nav>
        <div class="p-4 border-t border-slate-200">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="flex items-center gap-3 p-3 text-red-500 hover:bg-red-50 w-full rounded-lg transition">
                    Sair
                </button>
            </form>
        </div>
    </aside>

    <!-- Main -->
    <main class="flex-1 overflow-y-auto">
        <header class="bg-white border-b border-slate-200 py-4 px-8 flex justify-between items-center">
            <h1 class="text-xl font-semibold text-slate-800">Visão Geral</h1>
            <div class="flex items-center gap-4">
                <div class="h-8 w-8 bg-indigo-100 text-indigo-700 rounded-full flex items-center justify-center font-bold">
                    {{ auth()->user()->name[0] ?? 'U' }}
                </div>
            </div>
        </header>

        <div class="p-8">
            @php
                $agendamentos = auth()->user()->agendamentos()->orderBy('data', 'desc')->get();
                $totalAgendamentos = $agendamentos->count();
                $statusCount = $agendamentos->groupBy('status')->map->count();
            @endphp

            <!-- Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <p class="text-slate-500 text-sm">Total de Agendamentos</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $totalAgendamentos }}</h3>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <p class="text-slate-500 text-sm">Agendados</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $statusCount['agendado'] ?? 0 }}</h3>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <p class="text-slate-500 text-sm">Concluídos</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $statusCount['concluido'] ?? 0 }}</h3>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <p class="text-slate-500 text-sm">Cancelados</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $statusCount['cancelado'] ?? 0 }}</h3>
                </div>
            </div>

            <!-- Agendamentos Recentes -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                    <h2 class="font-semibold text-slate-800">Agendamentos Recentes</h2>
                    <a href="{{ route('agendamentos.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm transition">
                        Novo Agendamento
                    </a>
                </div>

                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Cliente</th>
                            <th class="px-6 py-4">Serviço</th>
                            <th class="px-6 py-4">Data</th>
                            <th class="px-6 py-4">Horário</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($agendamentos as $agendamento)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 font-medium text-slate-700">{{ $agendamento->cliente }}</td>
                            <td class="px-6 py-4 text-slate-500 text-sm">{{ $agendamento->servico }}</td>
                            <td class="px-6 py-4 text-slate-500 text-sm">{{ $agendamento->data }}</td>
                            <td class="px-6 py-4 text-slate-500 text-sm">{{ $agendamento->horario }}</td>
                            <td class="px-6 py-4 capitalize">
                                {{ $agendamento->status }}
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <!-- Editar -->
                                <a href="{{ route('agendamentos.edit', $agendamento->id) }}" class="text-slate-400 hover:text-indigo-600">
                                    ✏️
                                </a>

                                <!-- Excluir -->
                                <form action="{{ route('agendamentos.destroy', $agendamento->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-slate-400 hover:text-red-600">
                                        🗑️
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-slate-400">
                                Nenhum agendamento cadastrado.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
@endsection