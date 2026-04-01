<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // usuário que criou
            $table->string('cliente');
            $table->string('servico');
            $table->date('data');
            $table->time('horario');
            $table->text('observacao')->nullable();
            $table->enum('status', ['agendado', 'concluido', 'cancelado'])->default('agendado');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('agendamentos');
    }
};