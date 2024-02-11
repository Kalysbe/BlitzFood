import {checkAccess, checkAuth} from "@/routes/checkers";

const Roles = () => import('@/pages/Dashboard/Roles')

const routes = [
    {
        path: '/roles',
        name: 'roles',
        component: Roles,
        meta: {
            middleware: [checkAuth],
            hideFooter: true
        }
    },
]

export default routes