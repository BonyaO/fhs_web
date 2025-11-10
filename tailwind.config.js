/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./resources/views/journal/**/*.blade.php",
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",

    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                serif: ['Merriweather', 'Georgia', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                navy: {
                    DEFAULT: '#0A2540',
                    dark: '#051828',
                    light: '#1E3A5F',
                },
                teal: {
                    DEFAULT: '#00B4A6',
                    50: '#E0F7F5',
                    100: '#B3EDE9',
                    200: '#80E3DC',
                    300: '#4DD9CF',
                    400: '#26CFC5',
                    500: '#00B4A6',
                    600: '#009688',
                    700: '#00786E',
                    800: '#005A54',
                    900: '#003C3A',
                },
                coral: {
                    DEFAULT: '#FF6B6B',
                    50: '#FFE8E8',
                    100: '#FFCFCF',
                    200: '#FFA3A3',
                    300: '#FF7777',
                    400: '#FF6B6B',
                    500: '#FF5555',
                    600: '#E85555',
                    700: '#D04444',
                    800: '#B83333',
                    900: '#A02222',
                },
            },
            fontSize: {
                '7xl': '5rem',
                '8xl': '6rem',
            },
            spacing: {
                '18': '4.5rem',
                '88': '22rem',
                '112': '28rem',
                '128': '32rem',
            },
            maxWidth: {
                '8xl': '88rem',
                '9xl': '96rem',
            },
            boxShadow: {
                'xl': '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
                '2xl': '0 25px 50px -12px rgba(0, 0, 0, 0.25)',
            },
        },
    },
    plugins: [
        forms,
    ],
};
