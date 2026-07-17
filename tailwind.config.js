import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
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
                // Paleta de marca "Concejal Mauro Santana".
                mauro: {
                    blue: {
                        light: '#EAF6FC',
                        soft: '#D3ECF9',
                        DEFAULT: '#3CA9E2',
                        dark: '#1F7CAF',
                    },
                    yellow: {
                        DEFAULT: '#FBBF24',
                        dark: '#D99E00',
                    },
                    dark: '#111827',
                    slate: '#1F2937',
                },
            },
        },
    },

    plugins: [forms],
};
