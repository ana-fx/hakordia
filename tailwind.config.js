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
                primary: '#4175cb',
                secondary: '#a9c941',
                accent: '#B62127',
                green: {
                    50: '#f2f6ff',
                    100: '#e3edff',
                    200: '#c7dcff',
                    300: '#a3c4f9',
                    400: '#7aa3ef',
                    500: '#4175cb',
                    600: '#2f5ca6',
                    700: '#234784',
                    800: '#1a3564',
                    900: '#10224a',
                },
                emerald: {
                    50: '#f6faeb',
                    100: '#eaf3ce',
                    200: '#d3e89d',
                    300: '#bfdd6d',
                    400: '#b1d54d',
                    500: '#a9c941',
                    600: '#8eab34',
                    700: '#6f8728',
                    800: '#53661e',
                    900: '#394714',
                },
            },
        },
    },

    plugins: [forms],
};
