<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Porta extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'nome',
        'ativa',
        'porta',
    ];

    public function host()
    {
        return $this->belongsToMany(Host::class, 'host_porta');
    }

    public function historicoportas() {
        return $this->hasMany(Historicoportas::class)->orderBy('created_at', 'desc');
    }
}
