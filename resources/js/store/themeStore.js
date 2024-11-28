import { reactive } from 'vue';

export const themeStore = reactive({
    currentTheme: localStorage.getItem('theme') || 'ninos', // Tema por defecto
    fontSize: localStorage.getItem('fontSize') || 'base', // Tamaño de fuente por defecto
    contrast: localStorage.getItem('contrast') === 'true' || false, // Contraste alto por defecto
    dayNightMode: localStorage.getItem('dayNightMode') === 'true' || false, // Modo Día/Noche por defecto

    setTheme(theme) {
        this.currentTheme = theme;
        localStorage.setItem('theme', theme);
        this.updateBodyClasses();
    },

    setFontSize(size) {
        this.fontSize = size;
        localStorage.setItem('fontSize', size);
        this.updateBodyClasses();
    },

    toggleContrast() {
        this.contrast = !this.contrast;
        localStorage.setItem('contrast', this.contrast);
        this.updateBodyClasses();
    },

    toggleDayNightMode() {
        this.dayNightMode = !this.dayNightMode;
        localStorage.setItem('dayNightMode', this.dayNightMode);
        this.updateBodyClasses();
    },

    updateBodyClasses() {
        document.body.className = ''; // Limpiar clases previas

        // Aplicar clases para el tema
        if (themeStore.currentTheme === 'ninos') {
            document.body.classList.add('bg-yellow-300', 'text-black');
        } else if (themeStore.currentTheme === 'jovenes') {
            document.body.classList.add('bg-blue-500', 'text-white');
        } else if (themeStore.currentTheme === 'adultos') {
            document.body.classList.add('bg-gray-800', 'text-white');
        }

        // Aplicar clases para el modo Día/Noche
        if (themeStore.dayNightMode) {
            document.body.classList.add('bg-gray-900', 'text-white');
        } else {
            document.body.classList.add('bg-white', 'text-black');
        }

        // Aplicar clases de contraste alto
        if (themeStore.contrast) {
            document.body.classList.add('contrast-200');
        }

        // Aplicar el tamaño de fuente
        if (themeStore.fontSize === 'small') {
            document.body.classList.add('text-sm');
        } else if (this.fontSize === 'large') {
            document.body.classList.add('text-lg');
        } else {
            document.body.classList.add('text-base');
        }
    }
});
