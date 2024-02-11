import {checkAuth} from "@/routes/checkers";

const Reports = () => import('@/pages/Dashboard/Reports')

const routes = [
    {path: '/reports/', redirect: '/reports/list'},
    {
        path: 'reports/:reportType',
        name: 'reports',
        component: Reports,
        meta: {
            middleware: [checkAuth],
            hideFooter: true, hideScroll: true
        },
        props: true
    }
]

export default routes