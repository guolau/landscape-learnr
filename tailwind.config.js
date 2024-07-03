/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.{vue,js,ts,jsx,tsx}",
    ],
    theme: {
        extend: {
            gridTemplateColumns: {
                16: "repeat(16, minmax(0, 1fr))",
            },
        },
    },
    plugins: [require("@tailwindcss/forms")],
};
