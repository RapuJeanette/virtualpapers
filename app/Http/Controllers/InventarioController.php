<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Inventario;
use App\Models\Producto;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventarios = Inventario::with('producto')->get();
        $productos = Producto::all();

        return Inertia::render('Admin/Inventarios', [
            'inventarios' => $inventarios,
            'productos' => $productos,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de la solicitud
        $validated = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'tipo_movimiento' => 'required|in:compra,venta',
            'cantidad_movimiento' => 'required|integer|min:1',
        ]);

        // Encontrar el producto
        $producto = Producto::findOrFail($validated['producto_id']);
        $cantidadDisponible = $producto->cantidad;

        // Determinar la nueva cantidad basada en el tipo de movimiento
        $nuevaCantidad = $validated['tipo_movimiento'] === 'compra'
            ? $cantidadDisponible + $validated['cantidad_movimiento']
            : $cantidadDisponible - $validated['cantidad_movimiento'];

        // Verificar si hay suficiente inventario en caso de una venta
        if ($validated['tipo_movimiento'] === 'venta' && $nuevaCantidad < 0) {
            return back()->withErrors(['cantidad_movimiento' => 'No hay suficiente inventario disponible.']);
        }

        // Actualizar la cantidad del producto
        $producto->update(['cantidad_disponible' => $nuevaCantidad]);

        // Registrar el movimiento en el inventario
        Inventario::create($validated + ['cantidad_disponible' => $nuevaCantidad]);

        // Redirigir al listado de inventarios
        return redirect()->route('admin.inventarios')->with('success', 'Movimiento registrado con éxito.');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inventario = Inventario::findOrFail($id);
        $inventario->delete();

        return redirect()->route('admin.inventarios')->with('success', 'Registro eliminado exitosamente.');
    }
}
