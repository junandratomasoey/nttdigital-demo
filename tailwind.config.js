/** Build CSS website demo: npx tailwindcss -i resources/css/demo.css -o public/css/demo.css --minify */
module.exports = {
    content: ['./resources/views/demo/**/*.blade.php', './resources/views/components/**/*.blade.php', './app/Support/**/*.php'],
    theme: { extend: {} },
    plugins: [],
};
