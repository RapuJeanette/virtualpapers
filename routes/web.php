<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\DetalleCompraController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PromocionController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\DetalleVentaController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ConsumirServicioController;
use App\Http\Controllers\EstadisticasController;

Route::get('/menu', [MenuController::class, 'index']);

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/ventas/cliente', [VentaController::class, 'crearVentaCliente']);
    Route::get('/ventas/cliente/{id}/detalle', [DetalleVentaController::class, 'mostrarDetalleVentaCliente']);
    Route::post('/ventas/cliente/{id}/detalle', [DetalleVentaController::class, 'agregarProductoVentaCliente']);
    Route::get('/products', [ProductoController::class, 'getAllProducts']);
    Route::post('/pagos/crear', [PagoController::class, 'crear'])->name('pagos.crear');
});


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/usuarios', [UsuarioController::class, 'index'])->name('admin.usuarios');
    Route::post('/admin/usuarios/{id}/asignar-rol', [UsuarioController::class, 'asignarRol'])->name('admin.usuarios.asignar-rol');
    Route::get('/admin/categorias', [CategoriaController::class, 'index'])->name('admin.categorias');
    Route::get('/admin/ventas', [VentaController::class, 'index'])->name('admin.ventas');
    Route::get('/admin/pagos', [PagoController::class, 'index'])->name('admin.pagos');
    Route::get('/admin/productos', [ProductoController::class, 'index'])->name('admin.productos');
    Route::get('/admin/promocion', [PromocionController::class, 'index'])->name('admin.promociones');
    Route::get('/admin/inventarios', [InventarioController::class, 'index'])->name('admin.inventarios');
    Route::get('/admin/compras', [CompraController::class, 'index'])->name('admin.compras');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::post('/categorias', [CategoriaController::class, 'store'])->name('admin.categorias.store');
    Route::put('/categorias/{id}', [CategoriaController::class, 'update'])->name('admin.categorias.update');
    Route::delete('/categorias/{id}', [CategoriaController::class, 'destroy'])->name('admin.categorias.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::post('/compras', [CompraController::class, 'store'])->name('admin.compras.store');
    Route::put('/compras/{id}', [CompraController::class, 'update'])->name('admin.compras.update');
    Route::delete('/compras/{id}', [CompraController::class, 'destroy'])->name('admin.compras.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::post('/ventas', [VentaController::class, 'store'])->name('admin.ventas.store');
    Route::put('/ventas/{id}', [VentaController::class, 'update'])->name('admin.ventas.update');
    Route::delete('/ventas/{id}', [VentaController::class, 'destroy'])->name('admin.ventas.destroy');
    Route::get('/ventas/{id}', [VentaController::class, 'show'])->name('admin.ventas.show');
});

Route::prefix('admin')->group(function () {
    Route::get('/detalleventas/{id}', [DetalleVentaController::class, 'show'])->name('admin.detalleventas');
    Route::post('/detalleventas/{venta_id}', [DetalleVentaController::class, 'store']);
});

Route::prefix('admin')->group(function () {
    Route::get('/detallecompras/{id}', [DetalleCompraController::class, 'show'])->name('admin.detallecompras');
    Route::post('/detallecompras/{compra_id}', [DetalleCompraController::class, 'store']);
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::post('/pagos', [PagoController::class, 'store'])->name('admin.pagos.store');
    Route::put('/pagos/{id}', [PagoController::class, 'update'])->name('admin.pagos.update');
    Route::delete('/pagos/{id}', [PagoController::class, 'destroy'])->name('admin.pagos.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::post('/productos', [ProductoController::class, 'store'])->name('admin.productos.store');
    Route::put('/productos/{id}', [ProductoController::class, 'update'])->name('admin.productos.update');
    Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('admin.productos.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::post('/promociones', [PromocionController::class, 'store'])->name('admin.promociones.store');
    Route::put('/promociones/{id}', [PromocionController::class, 'update'])->name('admin.promociones.update');
    Route::delete('/promociones/{id}', [PromocionController::class, 'destroy'])->name('admin.promociones.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::post('/inventarios', [InventarioController::class, 'store'])->name('admin.inventarios.store');
    Route::put('/inventarios/{id}', [InventarioController::class, 'update'])->name('admin.inventarios.update');
    Route::delete('/inventarios/{id}', [InventarioController::class, 'destroy'])->name('admin.inventarios.destroy');
});


Route::get('/pagos', function () {
    return Inertia::render('PagoFacil');  // El nombre debe coincidir exactamente con el componente
})->name('pagos.index');


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/recolectar-datos', [ConsumirServicioController::class, 'recolectarDatos'])->name('recolectar.datos');
    Route::post('/consultar', [ConsumirServicioController::class, 'consultarEstado'])->name('consultar.estado');
    Route::post('/urlcallback', [ConsumirServicioController::class, 'urlCallback'])->name('url.callback');
});

Route::get('/estadisticas/ventas-totales', [EstadisticasController::class, 'ventasTotales']);
Route::get('/estadisticas/ventas-por-producto', [EstadisticasController::class, 'ventasPorProducto']);
Route::get('/estadisticas/clientes-nuevos', [EstadisticasController::class, 'clientesNuevos']);
Route::get('/estadisticas/ventas-por-periodo', [EstadisticasController::class, 'ventasPorPeriodo']);
Route::get('/estadisticas', [EstadisticasController::class, 'index'])->name('estadisticas.index');




