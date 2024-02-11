/** @type {import('tailwindcss').Config} */

module.exports = {
  content: [
    "./pages/**/*.{js,ts,jsx,tsx}",
    "./components/**/*.{js,ts,jsx,tsx}",
    './src/**/*.{html,js}', './node_modules/tw-elements/dist/js/**/*.js'
  ],
  darkMode: ['class'],
  theme: {
    extend: {
      colors:{
        primary:'#57b6c0',
        littleTransparent:'rgba(0,0,0,0.35)',
        lightTransparent:'rgba(255,255,255,0.25)'
      }
    },
  },
  plugins: [
    require('tw-elements/dist/plugin')
  ],
}