import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import preset from './vendor/filament/support/tailwind.config.preset'

/** @type {import('tailwindcss').Config} */
export default {
    presets: [preset],
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                raisaDongker1: '#18265C', // Background
                raisaDongker2: '#2a3f8c', // Gradient second color
                raisaBlueLight: '#60A5FA', // blue light
                gradientLight1: '#d9d9d9', // Gradient light start
                gradientLight2: '#ffffff', // Gradient light end
                gradientDark0: '#121212', // Gradient dark start
                gradientDark1: '#242424', // Gradient dark start
                gradientDark2: '#3a3a3a', // Gradient dark end
            },
        },
    },

    plugins: [forms],
};
