<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'usuario_administrador_id'];

    public function administrador()
    {
        return $this->belongsTo(User::class, 'usuario_administrador_id');
    }
}
