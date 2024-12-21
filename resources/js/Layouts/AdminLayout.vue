<template>
    <div class="flex flex-col min-h-screen">
        <header class="p-4 text-white bg-blue-600">
            <h1 class="text-lg font-bold">Panel Administrativo</h1>
        </header>

        <div class="flex flex-1">
            <!-- Sidebar -->
            <aside class="w-64 p-4 text-white bg-gray-800">
                <nav>
                    <ul>
                        <li><router-link to="/admin/ventas"
                                class="block px-4 py-2 hover:bg-gray-700">Ventas</router-link></li>
                        <li><router-link to="/admin/usuarios"
                                class="block px-4 py-2 hover:bg-gray-700">Usuarios</router-link></li>
                        <li><router-link to="/admin/categorias"
                                class="block px-4 py-2 hover:bg-gray-700">Categoria</router-link></li>
                        <li><router-link to="/admin/pagos" class="block px-4 py-2 hover:bg-gray-700">Pagos</router-link>
                        </li>
                        <li><router-link to="/admin/productos"
                                class="block px-4 py-2 hover:bg-gray-700">Productos</router-link></li>
                        <li><router-link to="/admin/promocion"
                                class="block px-4 py-2 hover:bg-gray-700">Promociones</router-link></li>
                        <li><router-link to="/admin/inventarios"
                                class="block px-4 py-2 hover:bg-gray-700">Inventario</router-link></li>
                        <li><router-link to="/admin/compras"
                                class="block px-4 py-2 hover:bg-gray-700">Compras</router-link></li>
                    </ul>
                </nav>
            </aside>


            <!-- Main Content -->
            <main class="flex-1 p-6 bg-gray-100">
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
</script>
