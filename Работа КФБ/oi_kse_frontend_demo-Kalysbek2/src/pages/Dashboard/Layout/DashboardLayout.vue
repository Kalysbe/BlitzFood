<template>
  <div
    class="wrapper"
    :class="[{'nav-open': $sidebar.showSidebar}, {rtl: $route.meta.rtlActive}]"
  >
    <notifications></notifications>
    <side-bar
      :active-color="sidebarBackground"
      :background-image="sidebarBackgroundImage"
      :data-background-color="sidebarBackgroundColor"
    >
      <user-menu></user-menu>
      <mobile-menu></mobile-menu>
      <template slot="links">
        <sidebar-item
          :link="{
            name: $t('pageDashboardLayout.myDocumentsSB'),
            icon: 'vertical_split',
            path: '/' + this.$i18n.locale + '/dashboard/reports'
          }"
        ></sidebar-item>

        <sidebar-item
          :link="{
            name: $t('pageDashboardLayout.createReportSB'),
            icon: 'note_add',
            path: '/' + this.$i18n.locale + '/dashboard/templates'
          }"
        ></sidebar-item>
        <sidebar-item
          v-if="isAdmin"
          :link="{name: $t('pageDashboardLayout.cartSB'), icon: 'delete', path: '/' + this.$i18n.locale + '/dashboard/cart'}"
        ></sidebar-item>

        <sidebar-item
          :link="{
            name: $t('pageDashboardLayout.legislationSB'),
            icon: 'gavel',
            path: '/' + this.$i18n.locale + '/dashboard/legislation'
          }"
        ></sidebar-item>
        <sidebar-item
          :link="{name: $t('pageDashboardLayout.manualSB'), icon: 'receipt', path: '/' + this.$i18n.locale + '/dashboard/manual'}"
        ></sidebar-item>

        <sidebar-item
          v-if="isAdmin"
          :link="{
            name: $t('pageDashboardLayout.manageAccountSB'),
            icon: 'manage_accounts',
            path: '/' + this.$i18n.locale + '/dashboard/manageaccounts'
          }"
        ></sidebar-item>
         <sidebar-item
          v-if="isAdmin"
          :link="{
            name: $t('pageDashboardLayout.slideEditingSB'),
            icon: 'image',
            path: '/' + this.$i18n.locale + '/dashboard/sliderediting'
          }"
        ></sidebar-item>
      </template>
    </side-bar>
    <div class="main-panel">
      <top-navbar></top-navbar>

      <!-- <fixed-plugin
        :color.sync="sidebarBackground"
        :colorBg.sync="sidebarBackgroundColor"
        :sidebarMini.sync="sidebarMini"
        :sidebarImg.sync="sidebarImg"
        :image.sync="sidebarBackgroundImage"
      >
      </fixed-plugin> -->

      <div :class="{content: !$route.meta.hideContent}" @click="toggleSidebar">
        <zoom-center-transition :duration="200" mode="out-in">
          <!-- your content here -->
          <router-view></router-view>
        </zoom-center-transition>
      </div>
      <content-footer v-if="!$route.meta.hideFooter"></content-footer>
    </div>
  </div>
</template>
<script>
/* eslint-disable no-new */
import PerfectScrollbar from 'perfect-scrollbar'
import 'perfect-scrollbar/css/perfect-scrollbar.css'

// function hasElement(className) {
//   return document.getElementsByClassName(className).length > 0
// }

function initScrollbar(className) {
  // if (hasElement(className)) {
  //   new PerfectScrollbar(`.${className}`)
  // } else {
  //   // try to init it later in case this component is loaded async
  //   setTimeout(() => {
  //     initScrollbar(className)
  //   }, 100)
  // }
}

import TopNavbar from './TopNavbar.vue'
import ContentFooter from './ContentFooter.vue'
import MobileMenu from './Extra/MobileMenu.vue'
// import FixedPlugin from "../../FixedPlugin.vue";
import UserMenu from './Extra/UserMenu.vue'
import {ZoomCenterTransition} from 'vue2-transitions'
import SidebarItem from '../../../components/SidebarPlugin/SidebarItem.vue'

export default {
  async created() {
    this.$sidebar.showSidebar = true
    if (localStorage.getItem('user') === 'admin') {
      this.isAdmin = true
    }
  },
  components: {
    TopNavbar,
    ContentFooter,
    MobileMenu,
    // FixedPlugin,
    UserMenu,
    ZoomCenterTransition,
    SidebarItem
  },
  data() {
    return {
      isAdmin: false,
      sidebarBackgroundColor: 'black',
      sidebarBackground: 'primary',
      sidebarBackgroundImage: '/img/main-background-image.jpeg',
      sidebarMini: false,
      sidebarImg: true
    }
  },
  methods: {
    toggleSidebar() {
      if (this.$sidebar.showSidebar) {
        this.$sidebar.displaySidebar(false)
      }
    },
    minimizeSidebar() {
      if (this.$sidebar) {
        this.$sidebar.toggleMinimize()
      }
    }
  },
  mounted() {
    let docClasses = document.body.classList
    let isWindows = navigator.platform.startsWith('Win')
    if (isWindows) {
      // if we are on windows OS we activate the perfectScrollbar function
      initScrollbar('sidebar')
      initScrollbar('sidebar-wrapper')
      initScrollbar('main-panel')

      docClasses.add('perfect-scrollbar-on')
    } else {
      docClasses.add('perfect-scrollbar-off')
    }
  },
  watch: {
    sidebarMini() {
      this.$sidebar.showSidebar = true
      // this.minimizeSidebar()
    }
  }
}
</script>
<style lang="scss">
.sidebar-wrapper {
  overflow-x: hidden;
  overflow-y: hidden;
}
$scaleSize: 0.95;
@keyframes zoomIn95 {
  from {
    opacity: 0;
    transform: scale3d($scaleSize, $scaleSize, $scaleSize);
  }
  to {
    opacity: 1;
  }
}
.main-panel .zoomIn {
  animation-name: zoomIn95;
}
@keyframes zoomOut95 {
  from {
    opacity: 1;
  }
  to {
    opacity: 0;
    transform: scale3d($scaleSize, $scaleSize, $scaleSize);
  }
}
.main-panel .zoomOut {
  animation-name: zoomOut95;
}
</style>