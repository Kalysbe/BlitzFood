import {Actions, Features} from '@/routes/consts'
import {checkAccess, checkAuth} from '@/routes/checkers'

const Accidents = () => import('@/pages/Dashboard/Monitoring/Accidents')
const AccidentProfileForm = () =>
  import('@/pages/Dashboard/Monitoring/Accidents/ProfileForm.vue')

// Environment imports
const Environments = () => import('@/pages/Dashboard/Monitoring/Environments')
const EnvironmentProfileForm = () =>
  import('@/pages/Dashboard/Monitoring/Environments/EnvironmentForm.vue')

const subDirPath = '/monitoring'
const routes = [
  {
    path: `${subDirPath}/accidents`,
    name: 'monitoring-accidents',
    component: Accidents,
    meta: {
      middleware: [checkAuth],
      hideFooter: true
    }
  },
  {
    path: `${subDirPath}/accidents/add`,
    name: 'accident-add',
    component: AccidentProfileForm,
    meta: {
      middleware: [checkAuth, checkAccess],
      hideFooter: true,
      feature: Features.accident,
      action: Actions.create
    },
    props: {act: 'new'}
  },
  {
    path: `${subDirPath}/accidents/upd/:accidentId`,
    name: 'accident-upd',
    component: AccidentProfileForm,
    meta: {
      middleware: [checkAuth, checkAccess],
      hideFooter: true,
      feature: Features.accident,
      action: Actions.update
    },
    props: (route) => {
      return {
        ...route.params,
        ...{accidentId: Number.parseInt(route.params.accidentId, 10)},
        act: 'upd'
      }
    }
  },
  // Environments routes
  {
    path: `${subDirPath}/environmental-monitoring`,
    name: 'monitoring-environments',
    component: Environments,
    meta: {
      middleware: [checkAuth],
      hideFooter: true
    }
  },
  {
    path: `${subDirPath}/environmental-monitoring/add`,
    name: 'environment-add',
    component: EnvironmentProfileForm,
    meta: {
      middleware: [checkAuth, checkAccess],
      hideFooter: true,
      feature: Features.environment,
      action: Actions.create
    },
    props: {act: 'new'}
  },
  {
    path: `${subDirPath}/environments/upd/:environmentId`,
    name: 'environment-upd',
    component: EnvironmentProfileForm,
    meta: {
      middleware: [checkAuth, checkAccess],
      hideFooter: true,
      feature: Features.environment,
      action: Actions.create
    },
    props: (route) => {
      return {
        ...route.params,
        ...{environmentId: Number.parseInt(route.params.environmentId, 10)},
        act: 'upd'
      }
    }
  }
]

export default routes
