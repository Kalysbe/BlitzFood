// const br_lang = (
//   navigator.browserLanguage ||
//   navigator.language ||
//   navigator.userLanguage ||
//   'en'
// ).substring(0, 2)

const user_lang = localStorage.getItem('rms-locale')

const locales = [
  {
    code: 'en',
    name: 'English'
  },
]

const selectLocale = user_lang //|| br_lang

const defaultLocale = selectLocale //locales.find((locale) => locale.code === selectLocale)
// ? selectLocale
// : 'en'

export {locales, defaultLocale}
