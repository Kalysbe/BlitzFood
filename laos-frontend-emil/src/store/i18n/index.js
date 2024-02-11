import api from '@/api/'
import {defaultLocale, locales} from './locales'
import i18n from '../../i18n'

export default {
    state: {
        locales: locales,
        active: defaultLocale,
        tr_list: [],
        UiTranslateLoaded: false,
        localesListLoaded: false
    },
    actions: {
        async LOAD_UI_TRANSLATE({commit}, lang) {
            try {
                const res = await api.localisation.load_ui_messages(lang)
                const {status, data} = res
                if (status === 200 && data) {
                    const messMixin = {...i18n.messages[lang]}
                    Object.keys(data).forEach((elem) => {
                        if (!messMixin.hasOwnProperty(elem)) {
                            messMixin[elem] = {}
                        }
                        Object.keys(data[elem]).map((item) => {
                            const val = data[elem][item]
                            messMixin[elem] = {...messMixin[elem], [item]: val}
                        })
                    })
                    i18n.setLocaleMessage(lang, messMixin)
                    commit('SET_UI_TRANSLATE_LOAD_STATE', true)
                } else {
                    throw 'no Data'
                }
            } catch (err) {
                console.log(err)
            }
        },
        async LOAD_LOGIN_TRANSLATE(context, lang) {
            try {
                console.log("LOAD_LOGIN_UI_TRANSLATE")
                const res = await api.localisation.load_login_messages(lang)
                const {status, data} = res
                if (status === 200) {
                    const messMixin = {...i18n.messages[lang]}
                    if (data) {
                        Object.keys(data).forEach((elem) => {
                            if (!messMixin.hasOwnProperty(elem)) {
                                messMixin[elem] = {}
                            }
                            Object.keys(data[elem]).map((item) => {
                                const val = data[elem][item]
                                messMixin[elem] = {...messMixin[elem], [item]: val}
                            })
                        })
                    }
                    i18n.setLocaleMessage(lang, messMixin)
                } else {
                    throw 'no Data'
                }
            } catch (err) {
                console.log(err)
            }
        },
        async LOAD_LOCALES_LIST({state, commit}) {
            try {
                const res = await api.localisation.load_locales()
                    const {status, data} = res
                if (status === 200 && data) {
                    commit('SET_LOCALES_LIST', {...data})
                    if (!state.active) {
                        const firstLang = state.locales.find((locale) => locale.index === 0)
                        commit('CHANGE_LANG', firstLang.code)
                    }
                } else {
                    throw 'no Data'
                }
            } catch (err) {
            }
        },
        async LOAD_TRANSLATION_LIST({commit}) {
            try {
                const res = await api.localisation.load_translate()
                const {status, data} = res
                if (status === 200 && data) {
                    commit('SET_TRANSLATION_LIST', data)
                } else {
                    throw 'no Data'
                }
            } catch (err) {
                console.log(err)
            }
        },
        async UPD_TRANSLATE_ENTRY({commit}, payload) {
            const {id, item} = payload
            try {
                const res = await api.localisation.upd_translate_entry(id, item)
                const {status} = res
                if (status === 200) {
                    commit('UPDATE_TRANSLATE_ITEM', item)
                } else {
                    throw 'no Data'
                }
            } catch (err) {
                throw err.response ? `${err.response.data.message}` : err
            }
        },
        async ADD_TRANSLATE_ENTRY({commit}, item) {
            try {
                const res = await api.localisation.add_translate_entry(item)
                const {status, data} = res
                if (status === 201 && data) {
                    commit('ADD_TRANSLATE_ITEM', data)
                } else {
                    throw 'no Data'
                }
            } catch (err) {
                throw err.response ? `${err.response.data.message}` : err
            }
        }
    },
    mutations: {
        SET_UI_TRANSLATE_LOAD_STATE(state, status) {
            state.UiTranslateLoaded = status
        },
        CHANGE_LANG(state, code) {
            state.active = code
            localStorage.setItem('rms-locale', code)
            i18n.locale = state.active
        },
        SET_TRANSLATION_LIST(state, list) {
            state.tr_list = list
        },
        SET_LOCALES_LIST(state, list) {
            Object.keys(list).forEach((item, index) => {
                const existLocaleId = state.locales.findIndex((locale) => locale.code === item)
                if (~existLocaleId) {
                    state.locales[existLocaleId].name = list[item]
                    state.locales[existLocaleId].index = index
                } else {
                    state.locales.push({code: item, name: list[item], index: index})
                }
            })
            state.localesListLoaded = true
        },
        UPDATE_TRANSLATE_ITEM(state, item) {
            const {category, key, ...langs} = item

            const ind = state.tr_list.findIndex((item) => {
                return item.category === category && item.key === key
            })
            if (ind > -1) {
                Object.keys(langs).forEach((lang) => {
                    state.tr_list[ind][lang] = langs[lang]
                })
            }
        },
        ADD_TRANSLATE_ITEM(state, item) {
            state.tr_list.push(item)
        }
    },
    getters: {
        isUiTranslateLoaded: (state) => state.UiTranslateLoaded,
        locale_active: (state) => state.active,
        isLangMessagesExist: () => (code) => {
            return Boolean(i18n.messages[code] && i18n.messages[code].menu)
        },
        isLangLoginMessagesExist: () => (code) => {
            return Boolean(i18n.messages[code] && i18n.messages[code].login)
        },
        localesListLoaded: (state) => state.localesListLoaded,


    }
}
