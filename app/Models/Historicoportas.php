<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Historicoportas extends Model
{
    use HasFactory, Notifiable;

    public function historico()
    {
        return $this->belongsTo(Historico::class);
    }

    public function porta()
    {
        return $this->belongsTo(Porta::class);
    }
}
