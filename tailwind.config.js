/** @type {import('tailwindcss').Config} */
export default {
    // Chỉ định các file Tailwind cần quét để lấy class (giảm dung lượng file CSS cuối)
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                // Định nghĩa màu chủ đạo giống CellphoneS (Đỏ)
                "brand-red": "#d70018",
                "brand-dark": "#222222",
            },
        },
    },
    plugins: [],
};
