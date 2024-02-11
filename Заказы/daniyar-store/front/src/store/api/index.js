// ---------------------------- axios запросы на бэкенд ----------------------------------//

import axios from 'axios'

const Api = axios.create({
  //  baseURL: 'https://m.kse.kg/api',
  // baseURL: 'http://192.168.0.180:8088/api',
  baseURL: 'http://127.0.0.1:8088/api',
  headers: {
    Accept: 'application/json'
  }
})

export default {
  getHost () {
    return Api.defaults.baseURL
  },
  // --------------------------Настройка axios----------------------- //
  // заголовок
  setHeaderAuth (token) {
    Api.defaults.headers.Authorization = `Bearer ${token}`
  },
  delHeaderAuth () {
    delete Api.defaults.headers.common.Authorization
  },
  isSetHeaderAuth () {
    const authHeader = Api.defaults.headers.Authorization
    return /Bearer (.*)/i.test(authHeader)
  },
  // --------------------------Авторизация-------------------------- //
  // авторизация в системе
  login (login, password) {
    return Api.post('/users/auth', {
      login,
      password
    })
  },
  // получение информации о пользователе
  getMe () {
    return Api.get('/users/me')
  },
  UserList () {
    return Api.get('/accounts/')
  },
  resetUserPassword (id) {
    return Api.put('/accounts/', id)
  },
  // обновление пароля
  changePass (password) {
    return Api.put('/users/password', {
      password
    })
  },

  updateInn (data) {
    return Api.put('/users/userinn', data)
  },

  getUserInn () {
    return Api.get('/users/userinn')
  },

  // добавление новой компании

  // добавление нового слайда
  addNewSlide (data) {
  // return Api.post('', data);
    return Api.post('/company/addNewSlide/', data, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    })
  },

  // ---------------------------Профиль----------------------------- //
  // получение информации о компании
  // обновление информации о компани

  // --------------------------Отчеты-------------------------------- //

  // Получение картинки слайдера
  getSliderImages () {
    return Api.post('/company/slider/', {
      headers: { 'Content-Type': 'Applicationjson' }
    })
  },
  deleteSlide (id) {
    return Api.delete('/company/deletingForeverSlide/' + id)
  }
  // получение всех шаблонов документов

}
