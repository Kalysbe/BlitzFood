import DashboardLayout from '@/pages/Dashboard/Layout/DashboardLayout.vue';
import AuthLayout from '@/pages/Dashboard/Pages/AuthLayout.vue';

import Home from '@/pages/Dashboard/Dashboard.vue';
import User from '@/pages/Dashboard/Pages/UserProfile.vue';
import Login from '@/pages/Dashboard/Pages/Login.vue';
import UserPassEdit from '@/pages/Dashboard/Pages/UserPassEdit.vue';
import PrintView from '@/pages/Dashboard/Pages/PrintView.vue';
import Cart from '@/pages/Dashboard/Pages/Cart.vue';
// import AddCompany from '@/pages/Dashboard/Pages/AddCompany.vue'
import DocComponent from '@/pages/Dashboard/Pages/DocComponent.vue';
import DocsTemplatesList from '@/pages/Dashboard/Pages/DocsTemplatesList.vue';
import UploadFile from '@/pages/Dashboard/Pages/UploadFile.vue';
import Manual from '@/pages/Dashboard/Pages/Manual.vue';
import Legislation from '@/pages/Dashboard/Pages/Legislation.vue';
import Reports from '@/pages/Dashboard/Pages/Reports.vue';
import ManageAccounts from '@/pages/Dashboard/Pages/ManageAccounts.vue';
import SliderEditing from '@/pages/Dashboard/Pages/SliderEditing.vue';

import Clothes from '@/pages/Dashboard/Pages/Clothes.vue'
import Category from '@/pages/Dashboard/Pages/Category.vue'
//import store from '@/store';
import store from '../store';
import i18n from '@/i18n'

//Main Content
import MainContent from '@/pages/Dashboard/Layout/MainContent.vue';
import Analytics from '@/pages/Dashboard/Layout/MainContent/pages/Analytics.vue';
import MainHome from '@/pages/Dashboard/Layout/MainContent/pages/Home.vue';
import OpenInformation from '@/pages/Dashboard/Layout/MainContent/pages/OpenInformation.vue';
import DetailCompany from '@/pages/Dashboard/Layout/MainContent/pages/DetailCompany.vue';
import DetailReport from '@/pages/Dashboard/Layout/MainContent/pages/DetailReport.vue';
import DetailAnalytics from '@/pages/Dashboard/Layout/MainContent/pages/DetailAnalytics.vue';
import Contacts from '@/pages/Dashboard/Layout/MainContent/pages/Contacts.vue';

const checkAuthAndAccess = async (to, from, next) => {
  //store.state.user.isAuth
  if (store.getters['auth/hasToken']) {
    store.commit('auth/SET_HEADER_AUTH');
  } 
  next();
};

let pages = {
  path: `dashboard`,
  // redirect: 'auth/login',
  component: DashboardLayout,
  beforeEnter: checkAuthAndAccess,
  children: [
    {
      path: 'profile',
      name: 'User Page',
      components: {default: User},
      beforeEnter: checkAuthAndAccess
    },
    {
      path: 'changepass',
      name: 'Change User Password',
      components: {default: UserPassEdit},
      beforeEnter: checkAuthAndAccess
    },
    {
      path: 'template/:id/:mode',
      name: 'Document Template',
      components: {default: DocComponent},
      beforeEnter: checkAuthAndAccess
    },
    {
      path: 'templates',
      name: 'Document Templates List',
      components: {default: DocsTemplatesList},
      beforeEnter: checkAuthAndAccess
    },
    {
      path: 'uploadfile',
      name: 'Upload file',
      components: {default: UploadFile},
      beforeEnter: checkAuthAndAccess
    },
    {
      path: 'manual',
      name: 'Manual',
      components: {default: Manual},
      beforeEnter: checkAuthAndAccess
    },
    {
      path: 'clothes',
      name: 'Clothes',
      components: {default: Clothes},
      beforeEnter: checkAuthAndAccess
    },
    {
      path: 'category',
      name: 'Category',
      components: {default: Category},
      beforeEnter: checkAuthAndAccess
    },
    {
      path: 'legislation',
      name: 'Legislation',
      components: {default: Legislation},
      beforeEnter: checkAuthAndAccess
    },
    {
      path: 'reports',
      name: 'Reports',
      components: {default: Reports},
      beforeEnter: checkAuthAndAccess
    },
    {
      path: 'home',
      name: 'Home',
      components: {default: Home},
      beforeEnter: checkAuthAndAccess
    },
    {
      path: 'printview/:id',
      name: 'Print View',
      components: {default: PrintView},
      beforeEnter: checkAuthAndAccess
    },
    {
      path: 'cart',
      name: 'Cart',
      components: {default: Cart},
      beforeEnter: checkAuthAndAccess
    }, 
    {
      path: 'manageaccounts',
      name: 'manageAccounts',
      components: {default: ManageAccounts},
      beforeEnter: checkAuthAndAccess
    },
    {
      path: 'sliderediting',
      name: 'sliderEditing',
      components: {default: SliderEditing},
      beforeEnter: checkAuthAndAccess
    },
    // {
    //   path: '/upload',
    //   name: 'FileUpload',
    //   components: {default: FileUpload},
    //   beforeEnter: checkAuthAndAccess
    // },
  ]
};

let auth = {
  path: 'auth',
  component: AuthLayout,
  name: 'Authentication',
  children: [
    {
      path: 'login',
      name: 'Login',
      component: Login
    },
  ]
};

let main = {
    path: '',
    component: MainContent, 
    children: [
      {
        path: '/',
        name: 'Главная',
        components:{default: MainHome} 
      },
      {
        path: 'openinformation',
        name: 'Центр раскрытие информации',
        component: OpenInformation,
        
      },
      {
        path: 'openinformation/company/:kod',
        name: 'Detail',
        component: DetailCompany
      },
      {
        path: 'openinformation/company/report/:id',
        name: 'DetailReport',
        component: DetailReport
      },
      {
        path: 'analytics',
        name: 'О Бирже',
        component: Analytics
      },
      {
        path: 'analytics/detailanalytics/:id',
        name: 'DetailtAnalytics',
        component: DetailAnalytics
      },
      {
        path: 'contacts',
        name: 'Контакты',
        component: Contacts
      },
    ]
}

let other = {
  path: 'main',
  name: 'notFound',
  component: MainContent
}

const routes = [
  {
    path: '/',
    redirect: `/${i18n.locale}`
  },
  {
    path: '/:lang',
    component: {
      render (c) { return c('router-view') }
    },
    children: [pages,auth, main, other]
  }
  
];


export default routes;