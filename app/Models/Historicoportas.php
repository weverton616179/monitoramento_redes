<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Historicoportas extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    public function historico()
    {
        return $this->belongsTo(Historico::class);
    }

    public function porta()
    {
        return $this->belongsTo(Porta::class);
    }
}
