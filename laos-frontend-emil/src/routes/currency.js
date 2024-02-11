import {checkAccess, checkAuth} from "@/routes/checkers";
import {Actions, Features} from "@/routes/consts";

const CurrencyRates = ()=> import('@/pages/Dashboard/Currency/Rates.vue')

const routes = [
    {
        path: '/contracts/currency-rates',
        name: 'currency-rates',
        component: CurrencyRates,
        meta: {
            middleware: [checkAuth],
            hideFooter: true
        },
        props: true
    },
]

export default routes