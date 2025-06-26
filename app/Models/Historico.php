<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

class Historico extends Model
{
    use HasFactory, Notifiable, SoftDeletes, SoftCascadeTrait;
    protected $softCascade = ['historicoportas'];

    public function host()
    {
        return $this->belongsTo(Host::class);
    }
    
    // public function historicoportas() {
    //     return $this->hasMany(Historicoportas::class);
    // }

    public function gravarhistorico() {
        $historico = new Historico();
        
    }
}
