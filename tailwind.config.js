/** @type {import('tailwindcss').Config} */
export default {
  darkMode:'class',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    './app/Filament/**/*.php',
    './resources/views/filament/**/*.blade.php',
    './vendor/filament/**/*.blade.php',
    './resources/**/*.css'
  ],
  theme: {
    extend: {
      colors:{
        'green-main':'#164138'
      }
    },
  },
  plugins: [
  ],
  
}

