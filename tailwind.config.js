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
                sans: ['Tajawal', 'Figtree', ...defaultTheme.fontFamily.sans],
                display: ['Playfair Display', 'serif'],
                arabic: ['Tajawal', 'sans-serif'],
            },
            colors: {
                brand: {
                    50: '#fdf2f4',
                    100: '#fce7ea',
                    200: '#f9c5cd',
                    300: '#f49ea9',
                    400: '#ee6e80',
                    500: '#e11d48',
                    600: '#be123c',
                    700: '#9f1239',
                    800: '#831235',
                    900: '#4c0519',
                },
                warm: {
                    50: '#fafaf5',
                    100: '#f5f2e8',
                    200: '#e8dfd0',
                    300: '#d4c8b4',
                    400: '#c4b49c',
                    500: '#b09c80',
                },
                gold: {
                    50: '#fef8e8',
                    100: '#fdf0cc',
                    200: '#fbdd99',
                    300: '#f4c55f',
                    400: '#e8a930',
                    500: '#c8a44e',
                    600: '#b08a38',
                    700: '#8a6c2a',
                },
            },
        },
    },

    plugins: [forms],
};
