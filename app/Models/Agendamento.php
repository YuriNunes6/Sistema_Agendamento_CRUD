<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cliente',
        'servico',
        'data',
        'horario',
        'observacao',
        'status',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}