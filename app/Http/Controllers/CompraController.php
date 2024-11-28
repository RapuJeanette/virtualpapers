<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\User;
use Inertia\Inertia;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::all();
        return Inertia::render('Admin/Compras', [
            'compras' => $compras,
            'usuarios' => User::all(),
        ]);

    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha_compra' => 'required|date',
            'total' => 'required|numeric',
            'usuario_id' => 'required|exists:users,id'
        ]);

        $compra = Compra::create($validated);

        return Inertia::render('Admin/Compras', [
            'compras' => Compra::all(),
            'usuarios' => User::all(),
        ]);
    }

    public function show($id)
    {
        $compra = Compra::with('usuario')->findOrFail($id); // Obtener una compra específica con su usuario relacionado
        return response()->json($compra);
    }

    public function update(Request $request, $id)
    {
        $compra = Compra::findOrFail($id);

        $total = $compra->detallecompras->sum(function ($detalle) {
            return $detalle->cantidad * $detalle->precio_unitario;
        });

        $compra->update([
            'total' => $total,
            'fecha_compra' => $request->input('fecha_compra', $compra->fecha_compra),
        ]);

        return Inertia::render('Admin/Compras', [
            'compras' => Compra::all(),
            'usuarios' => User::all(),
        ]);
    }

    public function destroy($id)
    {
        $compra = Compra::findOrFail($id);
        $compra->delete();

        return Inertia::render('Admin/Compras', [
            'compras' => Compra::all(),
            'usuarios' => User::all(),
        ]);

    }
}
