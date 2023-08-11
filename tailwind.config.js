/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                'red-primary': '#B31312',
                'white-secondary': '#F8F0ED',
            },
            fontFamily:{
                'poppins': ['Poppins', 'sans-serif'],
            }
        },
    },
    plugins: [],
};
