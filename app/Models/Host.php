<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Host extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nome',
        'ip',
        'ativa',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_host');
    }

    public function historicos() {
        return $this->hasMany(Historico::class)->orderBy('created_at', 'desc');
    }

    public function historico_recente() {
        // return $this->historicos()->orderBy('created_at', 'desc')->first();
    }

    public function portas() {
        // return $this->hasMany(Porta::class);
        return $this->belongsToMany(Porta::class, 'host_porta');
    }
}
