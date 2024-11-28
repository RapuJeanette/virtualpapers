<template>
    <div class="space-x-4">
        <button @click="setTheme('ninos')" class="p-2 text-white bg-yellow-400 rounded-lg hover:bg-yellow-300">Tema
            Niños</button>
        <button @click="setTheme('jovenes')" class="p-2 text-white bg-blue-500 rounded-lg hover:bg-blue-400">Tema
            Jóvenes</button>
        <button @click="setTheme('adultos')" class="p-2 text-white bg-gray-800 rounded-lg hover:bg-gray-700">Tema
            Adultos</button>

        <button @click="toggleDayNight" class="p-2 text-white bg-purple-500 rounded-lg hover:bg-purple-400">Modo
            Día/Noche</button>

        <button @click="setFontSize('small')" class="p-2 text-white bg-green-500 rounded-lg hover:bg-green-400">Tamaño
            Pequeño</button>
        <button @click="setFontSize('base')" class="p-2 text-white bg-green-500 rounded-lg hover:bg-green-400">Tamaño
            Normal</button>
        <button @click="setFontSize('large')" class="p-2 text-white bg-green-500 rounded-lg hover:bg-green-400">Tamaño
            Grande</button>

        <button @click="toggleContrast" class="p-2 text-white bg-red-500 rounded-lg hover:bg-red-400">Contraste
            Alto</button>
    </div>
</template>

<script setup>
import { themeStore } from '@/store/themeStore.js';

const setTheme = themeStore.setTheme.bind(themeStore); // Asegurarse de usar el contexto correcto
const setFontSize = themeStore.setFontSize.bind(themeStore);
const toggleContrast = themeStore.toggleContrast.bind(themeStore);
const toggleDayNightMode = themeStore.toggleDayNightMode.bind(themeStore);
</script>


<style scoped>
/* Puedes agregar aquí estilos específicos si es necesario */
</style>
