<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::select('id', 'nombre', 'apellido', 'email', 'rol', 'created_at')
            ->get();

        $roles = ['admin', 'encargado', 'proveedor', 'cliente']; // Roles disponibles

        return Inertia::render('Admin/Usuarios', [
            'usuarios' => $usuarios->toArray(),
            'roles' => $roles,
        ]);
    }

    // Asignar rol a un usuario
    public function asignarRol(Request $request, User $user)
    {
        $user->assignRole($request->rol);

        // Redirige de vuelta con mensaje flash
        return redirect()->route('admin.usuarios')
            ->with('flash.success', 'Rol asignado correctamente.');
    }
}
