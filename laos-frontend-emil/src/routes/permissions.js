const Permissions = () => import('@/pages/Dashboard/Permissions.vue')

import {Actions, Features} from "@/routes/consts";
import {checkAccess, checkAuth} from "@/routes/checkers";

const routes = [
    {
        path: '/permissions',
        name: 'Permissions',
        components: {default: Permissions},
        meta: {
            middleware: [checkAuth, checkAccess],
            hideFooter: true,
            feature: Features.permissions,
            action: Actions.list
        }
    },
]

export default routes