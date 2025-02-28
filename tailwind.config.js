import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/preline/dist/*.js', // Add this line
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                gntf_green: {
                  DEFAULT: '#1fa147', // Base color
                  50: '#e6f7ec',
                  100: '#c8efd5',
                  200: '#94e1aa',
                  300: '#61d27f',
                  400: '#2cc454',
                  500: '#1fa147', // Default (base) shade
                  600: '#188638',
                  700: '#136a2d',
                  800: '#0e4e22',
                  900: '#092f16',
                },
            },



        },
    },

    plugins: [forms,
        require('preline/plugin'), // Add this line
    ],
};
