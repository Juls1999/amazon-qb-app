/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./includes/**/*.php",
    "./pages/**/*.php",
    "./scripts/**/*.js",
    "./index.php",
  ],
  theme: {
    extend: {
      fontFamily: {
        faustina: ["Faustina", "sans-serif"],
        anton: ["Anton", "sans-serif"],
      },
    },
  },
  plugins: [],
};
