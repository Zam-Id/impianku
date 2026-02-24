/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "media",
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            // Menambahkan custom font (jika kamu pakai Plus Jakarta Sans/MiSans)
            fontFamily: {
                sans: [
                    '"Plus Jakarta Sans"',
                    "ui-sans-serif",
                    "system-ui",
                    "sans-serif",
                ],
            },
            // Menambahkan racikan warna gradient kamu
            colors: {
                impian: {
                    100: "#fff6e0", // Warna background tipis (untuk hover/badge)
                    300: "#ffde95", // Warna utama pilihanmu! ✨
                    500: "#f5b83d", // Warna gradient pasangannya (lebih gelap)
                    700: "#b37a12", // Warna teks agar kontras dan mudah dibaca
                },
            },
        },
    },
    plugins: [],
};
