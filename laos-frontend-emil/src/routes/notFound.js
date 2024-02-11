import {checkAuth} from "@/routes/checkers";
const notFoundComponent = () => import('@/pages/NotFoundComponent')

const routes = [
    {
        path: 'page-not-found',
        name: 'page-not-found',
        component: notFoundComponent,
        meta: {
            target: 'page-not-found',
            hideFooter: true,
            middleware: [checkAuth]
        }
    },
]

export default routes