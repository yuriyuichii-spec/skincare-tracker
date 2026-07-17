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
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                display: ['Quicksand', ...defaultTheme.fontFamily.sans],
                body: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                cream: '#FDF6F0',
                ink: '#5C4B51',
                blush: {
                    50: '#FFF5F8',
                    100: '#FDE8EF',
                    200: '#FBD0DF',
                    300: '#F7AECB',
                    400: '#F08FB4',
                    500: '#E5709C',
                    600: '#D2578A',
                    700: '#B23F70',
                },
                sage: {
                    100: '#EEF3E9',
                    400: '#A9C29B',
                    600: '#7C9B6C',
                },
                peach: {
                    100: '#FCEEE0',
                    400: '#F0B67F',
                    600: '#D89354',
                },
                rose: {
                    100: '#FBE4E8',
                    400: '#E38DA0',
                    600: '#C65D75',
                },
            },
        },
    },

    plugins: [forms],
};