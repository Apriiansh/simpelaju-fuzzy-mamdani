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
                sans: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
                serif: ['Lora', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                'cream': '#F6F3EE',
                'paper': '#EDEAE3',
                'forest': {
                    DEFAULT: '#1A3A2A',
                    'dark': '#132C20',
                    'light': '#274D39',
                },
                'premium-amber': {
                    DEFAULT: '#B5850A',
                    'light': '#D4A017',
                },
                'premium-muted': '#6B6659',
                'premium-border': '#D8D4CB',
            },
        },
    },

    plugins: [forms],
};
