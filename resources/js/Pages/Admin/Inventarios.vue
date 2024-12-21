<script setup>
import { ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
import AdminLayout from "@/Layouts/AdminLayout.vue";

const props = defineProps({
    inventarios: Array,
    productos: Array,
});

const form = ref({
    producto_id: "",
    tipo_movimiento: "compra",
    cantidad_movimiento: 1,
});

const getProductoNombre = (productoId) => {
    const producto = props.productos.find(p => p.id === productoId);
    return producto ? producto.nombre : 'Producto no encontrado';
};

const registrarMovimiento = () => {
    if (!form.value.producto_id) {
        alert("Por favor, selecciona un producto.");
        return;
    }

    Inertia.post('https://mail.tecnoweb.org.bo/inf513/grupo07sa/proyecto2/public/admin/inventarios', form.value, {
        onSuccess: () => {
            form.value.producto_id = "";
            form.value.tipo_movimiento = "compra";
            form.value.cantidad_movimiento = 1;
        },
    });
};


const eliminarMovimiento = (id) => {
    if (confirm("¿Estás seguro de eliminar este registro?")) {
        Inertia.delete(route("admin.inventarios.destroy", { id }));
    }
};

</script>

<template>
    <AdminLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Gestión de Inventario</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
                <!-- Formulario para registrar movimiento -->
                <div class="p-6 bg-white shadow sm:rounded-lg">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Registrar Movimiento</h3>
                    <form @submit.prevent="registrarMovimiento" class="mt-4 space-y-4">
                        <div>
                            <label for="producto_id" class="block text-sm font-medium text-gray-700">Producto</label>
                            <select v-model="form.producto_id" id="producto_id"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="" disabled>Seleccione un producto</option>
                                <option v-for="producto in props.productos" :key="producto.id" :value="producto.id">
                                    {{ producto.nombre }}
                                </option>
                            </select>
                        </div>

                        <div>
                            <label for="tipo_movimiento" class="block text-sm font-medium text-gray-700">Tipo de
                                Movimiento</label>
                            <select v-model="form.tipo_movimiento" id="tipo_movimiento"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="compra">Compra</option>
                                <option value="venta">Venta</option>
                            </select>
                        </div>

                        <div>
                            <label for="cantidad_movimiento"
                                class="block text-sm font-medium text-gray-700">Cantidad</label>
                            <input type="number" v-model="form.cantidad_movimiento" id="cantidad_movimiento" min="1"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                        </div>

                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring focus:ring-indigo-300 disabled:opacity-25">
                            Registrar
                        </button>
                    </form>
                </div>

                <!-- Tabla de movimientos -->
                <div class="p-6 bg-white shadow sm:rounded-lg">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Historial de Movimientos</h3>
                    <table class="w-full mt-4 border border-collapse border-gray-200 table-auto">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left border border-gray-200">Producto</th>
                                <th class="px-4 py-2 text-left border border-gray-200">Tipo</th>
                                <th class="px-4 py-2 text-left border border-gray-200">Cantidad</th>
                                <th class="px-4 py-2 text-left border border-gray-200">Cantidad Disponible</th>
                                <th class="px-4 py-2 text-left border border-gray-200">Fecha</th>
                                <th class="px-4 py-2 text-left border border-gray-200">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="inventario in props.inventarios" :key="inventario.id">
                                <td class="px-4 py-2 border border-gray-200">
                                    {{ getProductoNombre(inventario.producto_id) }}
                                </td>
                                <td class="px-4 py-2 border border-gray-200">{{ inventario.tipo_movimiento }}</td>
                                <td class="px-4 py-2 border border-gray-200">{{ inventario.cantidad_movimiento }}</td>
                                <td class="px-4 py-2 border border-gray-200">{{ inventario.cantidad_disponible }}</td>
                                <td class="px-4 py-2 border border-gray-200">{{ inventario.created_at }}</td>
                                <td class="px-4 py-2 border border-gray-200">
                                    <button @click="eliminarMovimiento(inventario.id)"
                                        class="text-red-600 hover:underline">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
