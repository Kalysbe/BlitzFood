import {checkAuth, checkLocales} from "@/routes/checkers";

import dashboard from "@/routes/dashboard";
import auth from "@/routes/auth"
import notFound from "@/routes/notFound";
import localisation from "@/routes/localisation";
import reports from "@/routes/reports";
import roles from "@/routes/roles"
import users from "@/routes/users"
import webGis from "@/routes/web-gis"
import permissions from "@/routes/permissions";
import oldContract from "@/routes/oldContracts";
import contracts from "@/routes/contracts";
import lots from '@/routes/lots'
import currency from "@/routes/currency"
import refLists from "@/routes/refLists";
import rams from "@/routes/rams"
import monitoring from "@/routes/monitoring";

import AuthLayout from "@/pages/Dashboard/Pages/AuthLayout";

const DashboardLayout = () =>
    import('@/pages/Dashboard/Layout/DashboardLayout.vue')

const defaultRoute = `/dashboard`

const routes = [
    {
        path: '/',
        redirect: defaultRoute
    },
    // App pages
    {
        path: '/',
        component: DashboardLayout,
        // beforeEnter: checkLocales,
        redirect: defaultRoute,
        children: [
            ...dashboard,
            ...localisation,
            ...webGis,
            ...reports,
            ...contracts,
            ...lots,
            ...oldContract,
            ...roles,
            ...users,
            ...permissions,
            ...currency,
            ...refLists,
            ...rams,
            ...monitoring,
            ...notFound
        ]
    },
    // Auth page
    {
        path: '/',
        component: AuthLayout,
        name: 'Authentication',
        beforeEnter: checkLocales,
        children: auth
    },
    // If there are some API problems
    {
        path: '/server-error',
        component: {
            render(h) {
                return h('div', '<a href="/">Some API Error !!! (Refresh)</a>')
            }
        }
    },
    // Any other routes
    {
        path: '*',
        redirect: 'page-not-found',
        beforeEnter: checkAuth
    }
]

export default routes
