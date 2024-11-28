<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Compra extends Model
{
    use HasFactory;

    protected $table = 'compra';

    protected $fillable = [
        'fecha_compra',
        'total',
        'usuario_id'
    ];

    // Relación con el modelo Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function detallecompras()
    {
        return $this->hasMany(DetalleCompra::class, 'compra_id');  // Asegúrate de que 'venta_id' es la clave foránea correcta
    }
}
