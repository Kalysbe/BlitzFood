import store from "@/store";

const checkLocales = async (to, from, next) => {
    try {
        if (!store.getters.localesListLoaded) {
            await store.dispatch('LOAD_LOCALES_LIST')
        }
        next()
    } catch (err) {
        console.log('checkLocales', err)
        next('/server-error')
    }
}

const userLogout = async (to, from, next) => {
    await store.dispatch('LOGOUT')
    next('/login')
}

const checkLoginLangMessage = async (to, from, next) => {
    const actLang = store.getters.locale_active
    try {
        await store.dispatch('LOAD_LOGIN_TRANSLATE', actLang)
        next()
    } catch (err) {
        next('/server-error')
    }
}

const checkAccess = async (to, from, next) => {
    const {permissions} = store.state.Login.me
    const {feature, action} = to.meta
    const fullAccess = true // for the test
    // if the features and action are in the permission list
    //if (fullAccess && permissions.some(item => item.feature === feature && item.action === action)) {
    if (fullAccess) { //  TODO must be changed prev row
        next()
    } else {
        console.log('checkAccess - no permit')
        next('/page-not-found')
    }
}

const checkAuth = async (to, from, next) => {
    if (store.getters.hasToken) {
        store.commit('SET_HEADER_AUTH')
        try {
            if (!store.getters.localesListLoaded) {
                await store.dispatch("LOAD_LOCALES_LIST")
            }

            if (!store.getters.profileLoaded) {
                await store.dispatch('GET_MY_PROFILE')
            }

            if (!store.getters.appOptionsLoaded) {
                await store.dispatch('LOAD_APP_OPTIONS')
            }

            const actLang = store.getters.locale_active
            if (!store.getters.isUiTranslateLoaded) {
                await store.dispatch('LOAD_UI_TRANSLATE', actLang)
            }
            next()
        } catch (err) {
            throw err
            next('/login')
        }
    } else {
        store.commit('SET_REDIRECT_AFTER_LOGIN', to.fullPath)
        next('/login')
    }
}

export {checkLocales, userLogout, checkLoginLangMessage, checkAccess, checkAuth}