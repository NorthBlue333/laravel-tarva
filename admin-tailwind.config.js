module.exports = {
  future: {
    removeDeprecatedGapUtilities: true,
  },
  purge: {
    enabled: false,
    content: [
      './resources/**/*.blade.php',
      './resources/**/*.js',
      './resources/**/*.vue',
    ],
  },
  darkMode: false,
  theme: {
    colors: {
      white: 'white',
      black: 'black',
      'ghost-white': '#FAFAFF',
      gray: {
        DEFAULT: '#30343F',
        medium: '#606980',
        'medium-light': '#8B93A7',
        dark: '#121317',
        light: '#BABDC9',
        lighter: '#E8E9ED',
        lightest: '#F4F4F6',
      },
      primary: {
        DEFAULT: '#273469',
      },
      secondary: {
        DEFAULT: '#1E2749',
        dark: '#E4D9FF',
      },
      tertiary: {
        DEFAULT: '#FF8811',
        medium: '#F57A00',
        shadow: '#E07000',
        light: '#FFA347',
      },
      green: {
        DEFAULT: '#44CC00',
      },
      red: {
        DEFAULT: '#E71D36',
      },
      orange: {
        DEFAULT: '#FF9F1C',
      },
    },

    extend: {
      height: {
        52: '13rem',
      },
      minWidth: {
        32: '8rem',
      },
      transitionProperty: {
        size:
          'margin, padding, height, width, min-height, min-width, font-size',
        'p-w': 'padding, width',
      },
      boxShadow: {
        checkbox: '0 0 0 1px #BABDC9',
      },
      backgroundImage: () => ({
        checkbox: 'url(/vendor/laravel-admin/assets/checked.svg)',
      }),
    },
  },
  variants: {
    extend: {
      padding: ['group-hover'],
      backgroundColor: ['focus', 'checked'],
      boxShadow: ['focus', 'checked'],
      backgroundImage: ['focus', 'checked'],
      borderWidth: ['last'],
    },
  },
  plugins: [
    require('tailwindcss-typography')({
      // all these options default to the values specified here
      ellipsis: false, // whether to generate ellipsis utilities
      hyphens: false, // whether to generate hyphenation utilities
      kerning: false, // whether to generate kerning utilities
      textUnset: false, // whether to generate utilities to unset text properties
      componentPrefix: 'c-', // the prefix to use for text style classes
    }),
    require('@tailwindcss/forms'),
  ],
}
