const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
        screens: {
            'xs': '320px',
            // => @media (min-width: 320px) { ... }

            'sm': '576px',
            // => @media (min-width: 576px) { ... }

            'md': '768px',
            // => @media (min-width: 768px) { ... }

            'lg': '992px',
            // => @media (min-width: 992px) { ... }

            'xl': '1201px',
            // => @media (min-width: 1200px) { ... }

            'xxl': '1401px',
            // => @media (min-width: 1400px) { ... }

            'xxxl': '1601px',
            // => @media (min-width: 1601px) { ... }

            'maxDesktop': { 'max': '1800px' },
            // => @media (max-width: 1700px) { ... }

            'max2Xl': { 'max': '1600px' },
            // => @media (max-width: 1600px) { ... }

            'maxXl': { 'max': '1400px' },
            // => @media (max-width: 1200px) { ... }

            'maxLg': { 'max': '1200px' },
            // => @media (max-width: 1200px) { ... }

            'maxMd': { 'max': '991px' },
            // => @media (max-width: 991px) { ... }

            'maxSm': { 'max': '767px' },
            // => @media (max-width: 767px) { ... }

            'maxXs': { 'max': '575px' },
            // => @media (max-width: 575px) { ... }


            'minMaxDesktop': { 'min': '1601px', 'max': '1800px' },
            // => @media (min-width: 1601px) and (max-width: 1800px) { ... }

            'minMaxLaptop': { 'min': '1401px', 'max': '1600px' },
            // => @media (min-width: 1401px) and (max-width: 1600px) { ... }

            'minMaxTablet': { 'min': '1201px', 'max': '1400px' },
            // => @media (min-width: 1201px) and (max-width: 1400px) { ... }

            'minMaxTab': { 'min': '992px', 'max': '1200px' },
            // => @media (min-width: 992px) and (max-width: 1200px) { ... }

            'minMaxTabSmall': { 'min': '768px', 'max': '991px' },
            // => @media (min-width: 768px) and (max-width: 991px) { ... }

            'minMaxMobile': { 'min': '576px', 'max': '767px' },
            // => @media (min-width: 576px) and (max-width: 576px) { ... }
        },
        container: {
            center: true,
            padding: '15px',
        }
    },

    plugins: [
        require('@tailwindcss/forms')
    ],
};
