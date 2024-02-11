import {checkAuth} from "@/routes/checkers";

const List = () => import('@/pages/Dashboard/RefLists')

const routes = [
    {
        path: '/ref-lists',
        name: 'ref-lists',
        component: List,
        meta: {
            middleware: [checkAuth],
            hideFooter: true,
        },
        props: true
    }
]

export default routes