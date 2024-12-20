<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { Inertia } from '@inertiajs/inertia';

const products = ref([]);

onMounted(async () => {
    try {
        const response = await axios.get('https://mail.tecnoweb.org.bo/inf513/grupo07sa/proyecto2/public/products');
        products.value = response.data;
    } catch (error) {
        console.error('Error fetching products:', error);
    }
});

const crearVentaYRedirigir = async () => {
    try {
        const userResponse = await axios.get('https://mail.tecnoweb.org.bo/inf513/grupo07sa/proyecto2/public/user'); // Obtener usuario logueado
        const usuarioId = userResponse.data.id;

        const response = await axios.post('https://mail.tecnoweb.org.bo/inf513/grupo07sa/proyecto2/public/ventas/cliente', {
            usuario_id: usuarioId,
            total: 0,
            estado: 'Pendiente',
        });
        const ventaId = response.data.id;

        Inertia.get(`/ventas/cliente/${ventaId}/detalle`);
    } catch (error) {
        console.error('Error creating sale:', error);
    }
};

</script>

<template>
    <AppLayout title="Home">
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        Bienvenido a nuestro Sistema
                    </h2>
                    <h2 class="text-2xl font-bold leading-tight text-gray-900">
                        Catálogo de Productos
                    </h2>
                </div>
                <!-- Botón Realizar Venta -->
                <button
                    @click="crearVentaYRedirigir"
                    class="px-4 py-2 text-sm font-medium text-white transition bg-green-600 rounded-lg shadow hover:bg-green-700">
                    Realizar Venta
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2 lg:grid-cols-3">
                            <div v-for="product in products" :key="product.id"
                                class="relative transition-shadow duration-300 border rounded-lg shadow-md group hover:shadow-lg">
                                <div class="p-4">
                                    <h4 class="text-lg font-bold text-center text-gray-800">{{ product.nombre }}</h4>
                                    <p class="mt-2 text-sm text-center text-gray-600">{{ product.descripcion }}</p>
                                    <div class="mt-4 text-center">
                                        <span class="text-lg font-semibold text-gray-900">Bs{{ product.precio }}</span>
                                    </div>
                                </div>
                                <div v-if="product.cantidad" class="absolute px-2 py-1 text-xs font-semibold text-white bg-blue-500 rounded-full shadow top-2 right-2">
                                    Stock: {{ product.cantidad }}
                                </div>
                            </div>
                        </div>

                        <div v-if="products.length === 0" class="mt-6 text-center">
                            <p class="text-gray-500">No hay productos disponibles en este momento.</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
