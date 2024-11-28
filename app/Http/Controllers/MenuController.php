<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();  // Obtén todos los menús de la base de datos
        return Inertia::render('Menu', [
            'menus' => $menus,  // Pasa los menús a la vista
        ]);
    }
}
