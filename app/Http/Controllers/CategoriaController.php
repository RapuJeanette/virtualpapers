<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Categoria;
use Illuminate\Support\Facades\Auth;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();

        return Inertia::render('Admin/Categorias', [
            'categorias' => $categorias,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:30', // Validar que el nombre sea requerido y tenga un máximo de 30 caracteres
        ]);

        $categoria = Categoria::create([
            'nombre' => $request->nombre,
            'usuario_administrador_id' => Auth::id(), // Usar el id del usuario autenticado
        ]);

        return response()->json($categoria, 201); // Código de estado 201 para 'Creado'
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:30', // Asegurarse de que el nombre sea válido
        ]);

        $categoria = Categoria::findOrFail($id);

        if ($categoria->usuario_administrador_id !== Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403); // Si el usuario no es el admin de esta categoría, denegar acceso
        }

        $categoria->update([
            'nombre' => $request->nombre,
        ]);

        return response()->json($categoria);
    }


    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);

        if ($categoria->usuario_administrador_id !== Auth::id()) {
            return response()->json(['error' => 'No autorizado'], 403); // Si el usuario no es el admin de esta categoría, denegar acceso
        }

        $categoria->delete();

        return response()->json(['message' => 'Categoría eliminada']);
    }
}
