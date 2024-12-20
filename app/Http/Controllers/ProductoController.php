<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with('categoria', 'proveedor')->get();
        $products = Producto::all();
        $categorias = Categoria::all();
        $usuarios = User::all(); // Obtener todos los usuarios, o filtrar según rol si es necesario
        return Inertia::render('Admin/Productos', compact('productos', 'categorias', 'usuarios', 'products'));
    }

    // Almacenar un nuevo producto
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'descripcion' => 'required|string|max:100',
            'precio' => 'required|numeric',
            'cantidad' => 'required|integer',
            'categoria_id' => 'required|exists:categorias,id',
            'proveedor_id' => 'required|exists:users,id',
        ]);

        $usuario = Auth::user();  // Obtiene el ID del usuario autenticado

        Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'cantidad' => $request->cantidad,
            'categoria_id' => $request->categoria_id,
            'usuario_registrador_id' => $usuario->id,
            'proveedor_id' => $request->proveedor_id,
        ]);


        return Inertia::render('https://mail.tecnoweb.org.bo/inf513/grupo07sa/proyecto2/public/admin/productos', [
            'productos' => Producto::all(),
            'categorias' => Categoria::all(),
            'usuarios' => User::all()
        ]);
    }

    // Mostrar el formulario para editar un producto
    public function edit(Producto $producto)
    {
        return Inertia::render('https://mail.tecnoweb.org.bo/inf513/grupo07sa/proyecto2/public/Admin/Productos', [
            'producto' => $producto,
            'categorias' => Categoria::all(),
        ]);
    }

    // Actualizar un producto
    public function update(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:50',
            'descripcion' => 'required|string|max:100',
            'precio' => 'required|numeric',
            'cantidad' => 'required|integer',
            'categoria_id' => 'required|exists:categorias,id',
            'usuario_registrador_id' => 'required|exists:usuarios,id',
            'proveedor_id' => 'required|exists:usuarios,id',
        ]);

        $producto->update($validated);

        return Inertia::render('https://mail.tecnoweb.org.bo/inf513/grupo07sa/proyecto2/public/admin/productos', [
            'categorias' => Categoria::all(),
        ]);
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();

        return Inertia::render('Admin/Productos', [
            'categorias' => Categoria::all(),
        ]);
    }

    public function getAllProducts()
    {
        $products = Producto::all();

        return response()->json($products);
    }
}
