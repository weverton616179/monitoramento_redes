<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tempo extends Model
{
    use HasFactory;

    protected $fillable = [
        'tempo',
        'next_run_at',
    ];

    public function hosts() {
        return $this->belongsToMany(Host::class, 'host_tempo');
    }

    public function portas() {
        return $this->belongsToMany(Porta::class, 'porta_tempo');
    }

    // public function portas() {
    //     return $this->hasMany(Porta::class);
        
    // }
}
