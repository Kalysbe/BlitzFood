import {Actions, Features} from "@/routes/consts";
import localisation from "@/api/localisation";
import {checkAccess, checkAuth} from "@/routes/checkers";

const Translate = () => import('@/pages/Dashboard/Translate')
const TranslateProfileForm = () =>
    import('@/pages/Dashboard/Translate/translateProfileForm.vue')

const routes = [
    {
        path: 'localisation',
        name: 'Localisation',
        component: Translate,
        meta: {
            middleware: [checkAuth, checkAccess],
            feature: 'localisation',
            action: 'list',
            hideFooter: true
        },
    },
    {
        path: 'localisation_add',
        name: 'Localisation_add',
        component: TranslateProfileForm,
        meta: {
            middleware: [checkAuth, checkAccess],
            feature: Features.localisation,
            action: Actions.create,
            hideFooter: true
        },
        props: {oper: 'add'}
    },
]

export default routes