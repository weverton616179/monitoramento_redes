<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Host extends Model
{
    use HasFactory, Notifiable;

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }
}
