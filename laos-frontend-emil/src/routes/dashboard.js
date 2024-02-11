import {checkAuth} from "@/routes/checkers";

const Dashboard = () => import('@/pages/Dashboard/Dashboard.vue')

const routes = [
    {
        path: '/dashboard/',
        name: 'Dashboard',
        component: Dashboard,
        meta: {
            middleware: [checkAuth],
            hideFooter: true
        },
        props: true
    }]

export default routes