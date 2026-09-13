/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            colors: {
                primary: '#079a92',
                'primary-2': '#325b55',
                highlight: '#FFEF01',
                canvas: '#ffffff',
                void: '#000000',
            },
            fontFamily: {
                headline: ['Fredoka', 'sans-serif'],
                subtitle: ['Nunito', 'sans-serif'],
                body: ['Poppins', 'sans-serif'],
            },
        },
    },
    plugins: [],
};