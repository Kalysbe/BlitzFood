import {checkAuth} from "@/routes/checkers";

const RamsImport = () => import('@/pages/Dashboard/Rams/Import.vue')

const routes = [
    {
        path: '/rams/import/',
        name: 'rams-import',
        component: RamsImport,
        meta: {
            middleware: [checkAuth],
            hideFooter: true
        },
        props: true
    },
]

export default routes