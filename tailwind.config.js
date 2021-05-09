module.exports = {
  purge: {
    enabled: true,
    content: [
      './storage/framework/views/*.php',
      './resources/**/*.blade.php',
      './resources/**/*.js',
      './resources/**/*.vue',
    ]
  },
  darkMode: 'class', // or 'media' or 'class'
  theme: {
    extend: {
      colors: {
        'dark-primary': '#17191A',
        'dark-secondary': '#252C31',
        'accent': '#3282B8',
        'accent-darker': '#176DA8',
        'light-primary': '#E5E5E5',
        'light-secondary': '#ffffff',
      }
    },
  },
  variants: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms')
  ],
}
