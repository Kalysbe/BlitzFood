
import {checkLoginLangMessage, userLogout} from "@/routes/checkers";

const Login = () => import('@/pages/Dashboard/Pages/Login.vue')
const routes = [

    {
        path: '/login',
        name: 'Login',
        component: Login,
        beforeEnter: checkLoginLangMessage
    },
    {
        path: '/logout',
        name: 'Logout',
        beforeEnter: userLogout
    }

]
export default routes