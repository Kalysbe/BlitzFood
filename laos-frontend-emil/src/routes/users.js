import {Actions, Features} from "@/routes/consts";
import {checkAccess, checkAuth} from "@/routes/checkers";

const Users = () => import('@/pages/Dashboard/Users')
const UserProfileForm = () => import('@/pages/Dashboard/Users/UserProfileForm')

const routes = [
    {
        path: '/users',
        name: 'users',
        component: Users,
        meta: {
            middleware: [checkAuth],
            hideFooter: true
        }
    },
    {
        path: '/users/add',
        name: 'user-add',
        component: UserProfileForm,
        meta: {
            middleware: [checkAuth, checkAccess],
            hideFooter: true,
            feature: Features.user,
            action: Actions.create
        },
        props: {act: 'new'}
    },
    {
        path: '/users/:login',
        name: 'user-upd',
        component: UserProfileForm,
        meta: {
            middleware: [checkAuth, checkAccess],
            hideFooter: true,
            feature: Features.user,
            action: Actions.update
        },
        props: {act: 'upd'}
    },
]

export default routes