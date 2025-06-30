<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;


class Host extends Model
{
    use HasFactory, Notifiable, SoftDeletes, SoftCascadeTrait;
    protected $softCascade = ['historicos', 'historicoportas'];

    protected $fillable = [
        'nome',
        'ip',
        'ativa',
        'monitorar',
        'perda_wng',
        'perda_crt',
        'tempo_wng',
        'tempo_crt',
        'tempo',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_host');
    }

    public function historicosAsc() {
        return $this->hasMany(Historico::class);
    }

    public function historicos() {
        return $this->hasMany(Historico::class)->orderBy('created_at', 'desc');
        
    }

    public function portas() {
        return $this->belongsToMany(Porta::class, 'host_porta')->withPivot('tempo');
    }

    public function historicoportas() {
        return $this->hasMany(Historicoportas::class)->orderBy('created_at', 'desc');
    }
}
