import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
        "./node_modules/flowbite/**/*.js"
    ],

    theme: {
        extend: {
            fontFamily: {
                
            },
            colors: {
                white           : '#FBFCFF',
                black           : '#0A0A0A',
                ligth_gray      : '#D9D9D9',
                dark_gray       : '#222222',
                primary         : '#E74694',
                secondary       : '#4B30CA',
                primary_darker  : '#BF125D',

                demo_primary        : '#05A8AA',
                demo_primary_soft   : '#ADDEDE',
                demo_secondary      : '#401F3E',
                demo_secondary_soft : '#AD9FAC',
                demo_white          : '#EEF0F2',
            },
            fontSize: {
                xxs: '0.6rem',
            },
            boxShadow: {
                cookie: '0 2px 4px 6px rgb(0 0 0 / 0.1)',
            }
        },
    },
    plugins: [
        forms,
        require('flowbite/plugin')
    ],
};
