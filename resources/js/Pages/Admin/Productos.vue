<template>
    <AppLayout>
        <AdminLayout>
            <div>
                <h1 class="mb-4 text-2xl font-bold">Gestión de Productos</h1>

                <button @click="showCreateModal" class="px-4 py-2 mb-4 text-white bg-blue-500 rounded">
                    Crear Nuevo Producto
                </button>

                <!-- Tabla para mostrar los productos -->
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left">Nombre</th>
                            <th class="px-4 py-2 text-left">Precio</th>
                            <th class="px-4 py-2 text-left">Cantidad</th>
                            <th class="px-4 py-2 text-left">Categoría</th>
                            <th class="px-4 py-2 text-left">Descripción</th>
                            <th class="px-4 py-2 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="producto in productos" :key="producto.id">
                            <td class="px-4 py-2">{{ producto.nombre }}</td>
                            <td class="px-4 py-2">{{ producto.precio }}</td>
                            <td class="px-4 py-2">{{ producto.cantidad }}</td>
                            <td class="px-4 py-2">{{ producto.categoria_id }}</td>
                            <td class="px-4 py-2">{{ producto.descripcion }}</td>
                            <td class="px-4 py-2">
                                <button @click="showEditModal(producto)"
                                    class="px-4 py-2 text-white bg-yellow-500 rounded">
                                    Editar
                                </button>
                                <button @click="deleteProducto(producto.id)"
                                    class="px-4 py-2 text-white bg-red-500 rounded">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Paginator :paginator="products" @page-changed="handlePageChange" class="mt-3" />

                <!-- Modal para crear o editar un producto -->
                <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                    <div class="w-1/3 p-6 bg-white rounded-md">
                        <h2 class="mb-4 text-xl font-bold">{{ isEditing ? 'Editar Producto' : 'Crear Producto' }}</h2>

                        <form @submit.prevent="isEditing ? updateProducto() : createProducto()">
                            <div class="mb-4">
                                <label for="nombre" class="block">Nombre</label>
                                <input v-model="form.nombre" type="text" id="nombre"
                                    class="w-full p-2 border border-gray-300 rounded" />
                                <span v-if="errors.nombre" class="text-sm text-red-500">{{ errors.nombre }}</span>
                            </div>

                            <div class="mb-4">
                                <label for="descripcion" class="block">Descripción</label>
                                <textarea v-model="form.descripcion" id="descripcion"
                                    class="w-full p-2 border border-gray-300 rounded"></textarea>
                                <span v-if="errors.descripcion" class="text-sm text-red-500">{{ errors.descripcion
                                    }}</span>
                            </div>

                            <div class="mb-4">
                                <label for="precio" class="block">Precio</label>
                                <input v-model="form.precio" type="number" id="precio"
                                    class="w-full p-2 border border-gray-300 rounded" />
                                <span v-if="errors.precio" class="text-sm text-red-500">{{ errors.precio }}</span>
                            </div>

                            <div class="mb-4">
                                <label for="cantidad" class="block">Cantidad:</label>
                                <input type="number" id="cantidad" v-model="form.cantidad"
                                    placeholder="Cantidad disponible" required
                                    class="w-full p-2 border border-gray-300 rounded">
                                <span v-if="errors.cantidad" class="text-sm text-red-500">{{ errors.cantidad }}</span>
                            </div>

                            <div class="mb-4">
                                <label for="categoria_id" class="block">Categoría</label>
                                <select v-model="form.categoria_id" id="categoria_id"
                                    class="w-full p-2 border border-gray-300 rounded">
                                    <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">
                                        {{ categoria.nombre }}
                                    </option>
                                </select>
                                <span v-if="errors.categoria_id" class="text-sm text-red-500">{{ errors.categoria_id
                                    }}</span>
                            </div>

                            <div class="mb-4">
                                <label for="proveedor_id" class="block">Proveedor</label>
                                <select v-model="form.proveedor_id" id="proveedor_id"
                                    class="w-full p-2 border border-gray-300 rounded">
                                    <option value="" disabled>Selecciona un proveedor</option>
                                    <option v-for="usuario in usuarios" :key="usuario.id" :value="usuario.id">
                                        {{ usuario.name }}
                                    </option>
                                </select>
                                <span v-if="errors.proveedor_id" class="text-sm text-red-500">{{ errors.proveedor_id
                                    }}</span>
                            </div>

                            <div class="flex justify-end">
                                <button type="button" @click="closeModal"
                                    class="px-4 py-2 mr-2 text-white bg-gray-500 rounded">Cancelar</button>
                                <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded">
                                    {{ isEditing ? 'Actualizar' : 'Crear' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AdminLayout>
    </AppLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, onMounted } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import Paginator from '@/Components/Paginator.vue';

const props = defineProps({
    productos: Object, // Cambiado para manejar productos como un objeto con paginación
    categorias: Array,
    usuarios: Array,
    products: Array,
});
const products = ref({
    data: [], // Productos iniciales
    current_page: 1,
    total_pages: 1,
});

const handlePageChange = (page) => {
    loadProducts(page);
}

const loadProducts = (page) => {
    fetch(`https://mail.tecnoweb.org.bo/inf513/grupo07sa/proyecto2/public/api/productos?page=${page}`)
        .then((response) => response.json())
        .then((data) => {
            products.value = data;  // Actualiza los productos paginados
        })
        .catch((error) => console.error('Error fetching products:', error));
}

onMounted(() => {
    loadProducts(products.value.current_page);
})

const showModal = ref(false);
const isEditing = ref(false)
const form = ref({
    id: null,
    nombre: '',
    descripcion: '',
    precio: '',
    cantidad: '',
    categoria_id: null,
    proveedor_id: null,
});
const errors = ref({});

const showCreateModal = () => {
    form.value = { id: null, nombre: '', descripcion: '', precio: '', cantidad: '', categoria_id: null, proveedor_id: null };
    errors.value = {};
    showModal.value = true;
    isEditing.value = false;
};

const showEditModal = (producto) => {
    form.value = { ...producto };
    errors.value = {};
    showModal.value = true;
    isEditing.value = true;
};

const closeModal = () => {
    showModal.value = false;
};

const createProducto = () => {
    errors.value = {};
    console.log(form.value);
    Inertia.post('https://mail.tecnoweb.org.bo/inf513/grupo07sa/proyecto2/public/admin/productos', form.value, {
        onSuccess: () => closeModal(),
        onError: (error) => { errors.value = error }
    });
};

const updateProducto = () => {
    errors.value = {};
    Inertia.put(`https://mail.tecnoweb.org.bo/inf513/grupo07sa/proyecto2/public/admin/productos/${form.value.id}`, form.value, {
        onSuccess: () => closeModal(),
        onError: (error) => { errors.value = error }
    });
};

const deleteProducto = (id) => {
    if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
        Inertia.delete(`/admin/productos/${id}`);
    }
};
</script>

<style scoped>
/* Puedes agregar tus estilos personalizados aquí */
</style>
