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
    protected $softCascade = ['historicos'];

    protected $fillable = [
        'nome',
        'ip',
        'ativa',
        'monitorar',
        'perda_wng',
        'perda_crt',
        'tempo_wng',
        'tempo_crt',
        'tempo_id',
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
        return $this->belongsToMany(Porta::class, 'host_porta');
    }

    public function tempos() {
        return $this->belongsToMany(Tempo::class, 'host_tempo');
    }
}
