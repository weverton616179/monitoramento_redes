<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Porta extends Model
{
    use HasFactory, Notifiable;

    public function host()
    {
        return $this->belongsTo(Host::class);
    }

    public function historicoportas() {
        return $this->hasMany(Historicoportas::class)->orderBy('created_at', 'desc');
    }
}
