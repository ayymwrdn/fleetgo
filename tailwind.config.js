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
        },
    },

    plugins: [forms],
};
/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                primary: {
                    light: '#0B7A3D',
                    dark: '#064E2B',
                    DEFAULT: '#0B7A3D',
                    hover: '#0A6B35',
                },
                secondary: {
                    light: '#1ABC9C',
                    dark: '#0D8B6F',
                    DEFAULT: '#1ABC9C',
                },
                background: {
                    light: '#F0F7F4',
                    dark: '#0A1F16',
                    DEFAULT: '#F0F7F4',
                },
                surface: {
                    light: '#FFFFFF',
                    dark: '#132B20',
                    DEFAULT: '#FFFFFF',
                },
                text: {
                    light: '#1A2E24',
                    dark: '#E8F0EC',
                    DEFAULT: '#1A2E24',
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}