module.exports = {
  purge: [
    './public/**/*.html',
    './src/**/*.vue',
    './src/**/*.js',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      colors:{
        /** Dark Purple https://colourco.de/monochrome/9/332b33 */
        purple: {
          900: '#000000',
          800: '#0F0D0F',
          700: '#1F1A1F',
          600: '#2E272E',
          DEFAULT: '#3E333E', //500
          400: '#4E3F4E',
          300: '#5E4C5E',
          200: '#6F586F',
          100: '#7F647F',
          50: '#8A6B8A',
        },
        /** Purple Highlight https://colourco.de/monochrome/9/523352 */
        purplehl: {
          900: '#030203',
          800: '#150D15',
          700: '#261826',
          600: '#372337',
          DEFAULT: '#492E49', //500
          400: '#5B385B',
          300: '#6D426D',
          200: '#7F4D7F',
          100: '#925792',
        },
        spacing: {
          7: '1.75rem',
        },

        'base-color-intense': '#523352',
        'base-color-300': '#623C62',
        'base-color-100': '#834F83',

        /* OLD color scheme
        'base-color': '#332B33',
        'base-color-darker': '#2C262C',
        'base-color-dark': '#302730',
        'base-color-light': '#393039',
        'base-color-lighter': '#3F343F',
        'base-color-intense': '#523352',
        'base-color-intense': '#523352', */
      },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
