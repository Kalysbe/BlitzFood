import {checkAuth} from "@/routes/checkers";

const WebGis = () => import('@/pages/Dashboard/Maps/Country')

const routes = [
    {
        path: '/web-gis/',
        name: 'Map',
        component: WebGis,
        meta: {
            middleware: [checkAuth],
            hideFooter: true, hideScroll: true
        },
        props: true
    },
]

export default routes