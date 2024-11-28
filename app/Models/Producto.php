<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'descripcion', 'precio', 'cantidad', 'categoria_id', 'usuario_registrador_id', 'proveedor_id'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function usuarioRegistrador()
    {
        return $this->belongsTo(User::class, 'usuario_registrador_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(User::class, 'proveedor_id');
    }
}
