<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'usuarios' => 100, // Ejemplo de estadísticas
                'productos' => 50,
                'ventas' => 20,
            ],
        ]);
    }
}
