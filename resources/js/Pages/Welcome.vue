<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
      <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
        <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
          <header class="flex items-center justify-between px-6 py-10 text-white bg-gray-800">
            <div class="flex items-center space-x-3">
              <img src="/images/virtuallogo.jpeg" alt="Logo" class="h-10"/>
              <span class="text-xl font-bold">Virtual Papers</span>
            </div>
            <nav v-if="canLogin" class="flex items-center space-x-4">
              <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="px-3 py-2 text-white hover:text-black/70 dark:text-white dark:hover:text-white/80 border border-transparent hover:border-[#FF2D20] rounded-md">
                Dashboard
              </Link>
              <template v-else>
                <Link :href="route('login')" class="px-3 py-2 text-white hover:text-black/70 dark:text-white dark:hover:text-white/80 border border-transparent hover:border-[#FF2D20] rounded-md">
                  Log in
                </Link>
                <Link v-if="canRegister" :href="route('register')" class="px-3 py-2 text-black bg-yellow-400 rounded-md hover:bg-yellow-500 dark:text-white dark:bg-yellow-500 dark:hover:bg-yellow-600">
                  Register
                </Link>
              </template>
            </nav>
          </header>

          <main class="mt-6 text-center">
            <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
              <h1 class="text-4xl font-bold text-gray-900 dark:text-white">
                Bienvenido a Nuestro Sistema
              </h1>
              <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
                Por favor, inicia sesión o regístrate para continuar.
              </p>
            </div>
          </main>

          <section class="py-16 features bg-gray-50">
            <div class="container mx-auto text-center">
              <h2 class="mb-8 text-2xl font-bold text-gray-900">Nuestras Características</h2>
              <div class="grid grid-cols-1 gap-8 feature-list sm:grid-cols-2 lg:grid-cols-3">
                <div class="p-6 bg-white rounded-lg shadow-lg feature-item">
                  <h3 class="text-xl font-semibold text-[#FF9999] mb-4">Fácil de Usar</h3>
                  <p class="text-gray-600">Interfaz intuitiva y fácil de usar.</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-lg feature-item">
                  <h3 class="text-xl font-semibold text-[#FF9999] mb-4">Seguridad</h3>
                  <p class="text-gray-600">Tus datos están siempre seguros con nosotros.</p>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-lg feature-item">
                  <h3 class="text-xl font-semibold text-[#FF9999] mb-4">Soporte 24/7</h3>
                  <p class="text-gray-600">Siempre estamos aquí para ayudarte.</p>
                </div>
              </div>
            </div>
          </section>

          <section class="py-16 testimonials bg-gray-50">
            <div class="container mx-auto text-center">
              <h2 class="mb-8 text-2xl font-bold text-gray-900">Testimonios</h2>
              <div class="grid grid-cols-1 gap-8 testimonial-list sm:grid-cols-2 lg:grid-cols-2">
                <div class="p-6 bg-white rounded-lg shadow-lg testimonial-item">
                  <p class="text-gray-600">"Este sistema ha mejorado nuestra productividad increíblemente."</p>
                  <span class="block mt-4 font-semibold text-gray-800">- Usuario Satisfecho</span>
                </div>
                <div class="p-6 bg-white rounded-lg shadow-lg testimonial-item">
                  <p class="text-gray-600">"La mejor decisión que hemos tomado para nuestro negocio."</p>
                  <span class="block mt-4 font-semibold text-gray-800">- Cliente Feliz</span>
                </div>
              </div>
            </div>
          </section>

          <footer class="py-16 text-sm text-center text-gray-700 bg-gray-800 dark:text-white/70">
            <p>&copy; 2024 Virtual Papers. Todos los derechos reservados.</p>
          </footer>
        </div>
      </div>
    </div>
  </template>

  <style scoped>
  /* No se necesita archivo CSS adicional, ya que todo está gestionado con Tailwind */
  </style>
