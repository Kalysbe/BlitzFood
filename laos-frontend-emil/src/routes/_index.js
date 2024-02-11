import store from '../store'
//import i18n from '../i18n'

const AuthLayout = () => import('@/pages/Dashboard/Pages/AuthLayout.vue')
const Login = () => import('@/pages/Dashboard/Pages/Login.vue')

const DashboardLayout = () =>
    import('@/pages/Dashboard/Layout/DashboardLayout.vue')
// Dashboard pages
// const Help = () => import('@/pages/Dashboard/Contracts/Help')
// const Api_Testing = () => import('@/pages/Dashboard/Contracts/Api_test')
//const Contracts = () => import('@/pages/Dashboard/Contracts/Contract')
//const ContractReports = () => import('@/pages/Dashboard/Contracts/Report')
//const ContractProfile = () => import('@/pages/Dashboard/Contracts/ContractProfile')
//const LotDetails = () => import('@/pages/Dashboard/Contracts/lots/LotDetails')
//const ContractReport = () => import('@/pages/Dashboard/Contracts/ContractReport')
const WebGis = () => import('@/pages/Dashboard/Maps/Country')
const Dashboard = () => import('@/pages/Dashboard/Dashboard.vue')
//const Planning = () => import('@/pages/Dashboard/_remove_Planning')
//const Plans = () => import('@/pages/Dashboard/_remove_Planning/plans')
//const PlanParams = () => import('@/pages/Dashboard/_remove_Planning/planParams')
const Reports = () => import('@/pages/Dashboard/Reports')
const Translate = () => import('@/pages/Dashboard/Translate')
const TranslateProfileForm = () =>
    import('@/pages/Dashboard/Translate/translateProfileForm.vue')

const userLogout = async (to, from, next) => {
    await store.dispatch('LOGOUT')
    next('/login')
}

const checkLocales = async (to, from, next) => {
    if (!store.getters.localesListLoaded) {
        await store.dispatch('LOAD_LOCALES_LIST')
    }
    next()
}

const checkLoginLangMessage = async (to, from, next) => {
    const actLang = store.getters.locale_active
    await store.dispatch('LOAD_LOGIN_TRANSLATE', actLang)
    next()
}

const checkAuthAndAccess = async (to, from, next) => {
    if (store.getters.hasToken) {
        store.commit('SET_HEADER_AUTH')
        try {
            if (!store.getters.profileLoaded) {
                await store.dispatch('GET_MY_PROFILE')
            }

            if (!store.getters.appOptionsLoaded) {
                await store.dispatch('LOAD_APP_OPTIONS')
            }

            //const locales = Object.keys(i18n.messages)
            const actLang = store.getters.locale_active

            if (!store.getters.isUiTranslateLoaded) {
                await store.dispatch('LOAD_UI_TRANSLATE', actLang)
            }
            next()
        } catch {
            next('/login')
        }
    } else {
        store.commit('SET_REDIRECT_AFTER_LOGIN', to.fullPath)
        next('/login')
    }
}

let authPages = {
    path: '/',
    component: AuthLayout,
    name: 'Authentication',
    beforeEnter: checkLocales,
    children: [
        // {
        //     path: '/login',
        //     name: 'Login',
        //     component: Login,
        //     beforeEnter: checkLoginLangMessage
        // },
        // {
        //     path: '/logout',
        //     name: 'Logout',
        //     beforeEnter: userLogout
        // }
    ]
}

const routes = [
    {
        path: '/',
        redirect: '/dashboard'
    },
    {
        path: '/',
        component: DashboardLayout,
        beforeEnter: checkLocales,
        children: [
            // {
            //     path: 'dashboard',
            //     name: 'Dashboard',
            //     component: Dashboard,
            //     meta: {hideFooter: true},
            //     beforeEnter: checkAuthAndAccess
            // },


            // {
            //     path: 'help',
            //     name: 'help',
            //     components: {default: Help},
            //     meta: {hideFooter: true},
            //     beforeEnter: checkAuthAndAccess
            // },
            // {
            //     path: 'apitest',
            //     name: 'apitest',
            //     components: {default: Api_Testing},
            //     meta: {hideFooter: true},
            //     beforeEnter: checkAuthAndAccess
            // },
            // {
            //     path: 'Contracts',
            //     name: 'contracts',
            //     components: {default: Contracts},
            //     meta: {hideFooter: true},
            //     beforeEnter: checkAuthAndAccess
            // },
            // {
            //     path: 'ContractProfile',
            //     name: 'contractprofile',
            //     components: {default: ContractProfile},
            //     meta: {hideFooter: true},
            //     beforeEnter: checkAuthAndAccess
            // },
            // {
            //     path: 'LotDetails',
            //     name: 'lotdetails',
            //     components: {default: LotDetails},
            //     meta: {hideFooter: true},
            //     beforeEnter: checkAuthAndAccess
            // },


            // {
            //     path: 'translate',
            //     name: 'Translate',
            //     components: {default: Translate},
            //     meta: {hideFooter: true},
            //     beforeEnter: checkAuthAndAccess
            // },
            // {
            //     path: 'translate_add',
            //     name: 'Translate_add',
            //     component: TranslateProfileForm,
            //     meta: {hideFooter: true},
            //     beforeEnter: checkAuthAndAccess,
            //     props: {oper: 'add'}
            // },


            {
                path: 'web-gis',
                name: 'web-gis',
                component: WebGis,
                meta: {hideFooter: true, hideScroll: true},
                beforeEnter: checkAuthAndAccess
            },
            // {path: '/_remove_planning', redirect: '/_remove_planning/data/def'},
            // {
            //     path: '_remove_planning/data/:plan_id',
            //     name: '_remove_Planning-data',
            //     components: {default: _remove_Planning},
            //     meta: {hideFooter: true, hideScroll: true},
            //     props: {default: true},
            //     beforeEnter: checkAuthAndAccess
            // },
            // {
            //     path: 'plans/',
            //     name: 'Plan-list',
            //     components: {default: Plans},
            //     meta: {hideFooter: true, hideScroll: true},
            //     props: {default: true},
            //     beforeEnter: checkAuthAndAccess
            // },
            // {
            //     path: 'plans/params/:plan_id',
            //     name: 'Plan-params',
            //     components: {default: PlanParams},
            //     meta: {hideFooter: true, hideScroll: true},
            //     beforeEnter: checkAuthAndAccess,
            //     props: {default: true}
            // },

            // {path: '/reports', redirect: '/reports/list'},
            // {
            //     path: 'reports/:reportType',
            //     name: 'general-reports',
            //     component: Reports,
            //     meta: {hideFooter: true, hideScroll: true},
            //     beforeEnter: checkAuthAndAccess,
            //     props: true
            // },

            // {path: '/contract-reports', redirect: '/contract-reports/list'},
            // {
            //     path: '/contract-reports/:reportType',
            //     name: 'contract-reports',
            //     component: ContractReports,
            //     meta: {hideFooter: true},
            //     beforeEnter: checkAuthAndAccess,
            //     props: true
            // },
        ]
    },
    authPages,
    {
        path: '*',
        redirect: '/dashboard'
    }
]

export default routes
